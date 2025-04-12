<?php

namespace App\Livewire\Admin\Member;

use App\Jobs\ProfileUpdateOtpJob;
use App\Mail\profileOtpMail;
use App\Models\User;
use App\Models\State;
use App\Models\Otp;
use Livewire\Component;
use App\Models\ApiPartner;
use App\Models\Retailer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileComponet extends Component
{
    public $state = [];
    public $id;
    public $user;
    public $password = [];
    public $tab = null;
    public $showOtpVerification = false;
    public $otp = '';
    public $generatedOtp = '';
    public $updateType = ''; // 'profile' or 'password'
    public $otpError = '';
    public $otpTimeRemaining = 300; // 5 minutes in seconds
    public $otpExpireAt = null;

    protected $listeners = ['verifyOtp'];

    public function mount()
    {
        $this->user = User::with('roles')->where('id', base64_decode(request()->id))->first();
        $this->state = User::with('roles')->where('id', base64_decode(request()->id))->first()->toArray();
        $this->id = $this->state['id'];
    }

    public function render()
    {
        $states = State::orderBy('name', 'ASC')->get();
        return view('livewire.admin.member.profile-componet', compact('states'));
    }

    public function initiateProfileUpdate()
    {
        // Validate inputs before sending OTP
        $validateData = Validator::make($this->state, [
            'name' => 'required|min:3|string',
            'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no,' . $this->id,
            'address' => 'required',
            'state_name' => 'required',
            'city' => 'required|string',
            'pincode' => 'required|numeric|min_digits:6|digits:6',
        ])->validate();

        // Make sure email isn't changed from the original
        if ($this->state['email'] !== $this->user->email) {
            $this->dispatch('show-form', [
                'type' => 'error',
                'message' => 'Email cannot be changed'
            ]);
            Session::flash('error', 'Email cannot be changed');
            $this->state['email'] = $this->user->email;
            return;
        }

        // Generate OTP and store in DB
        $this->updateType = 'profile';
        $this->generateAndStoreOtp();
    }

    public function initiatePasswordChange()
    {
        $this->tab = "password manager";
        // Validate inputs before sending OTP
        $validateData = Validator::make($this->password, [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8',
        ])->validate();

        if (!Hash::check($validateData['old_password'], $this->user->password)) {
            Session::flash('error', "Your old password doesn't match");
            return;
        }

        // Generate OTP and store in DB
        $this->updateType = 'password';
        $this->generateAndStoreOtp();
    }

    protected function generateAndStoreOtp()
    {
        // Generate a 6-digit OTP
        $this->generatedOtp = rand(100000, 999999);

        // Set expiry time - 5 minutes from now
        $expireAt = now()->addMinutes(5);
        $this->otpExpireAt = $expireAt;
        $this->otpTimeRemaining = 300; // 5 minutes in seconds

        // Store OTP in database
        Otp::create([
            'user_id' => $this->id,
            'otp' => $this->generatedOtp,
            'expire_at' => $expireAt,
            'is_used' => false,
                    // OTP valid for 5 minutes
        ]);

        // Clear any previous errors
        $this->otpError = '';

        // Send OTP
        $this->sendOtp();

        // Show OTP verification UI
        $this->showOtpVerification = true;

        // Also add a session flash message
        Session::flash('info', 'An OTP has been sent to your mobile number. Please verify to continue.');
    }

    public function verifyOtp()
    {
        // Clear previous errors
        $this->otpError = '';

        // Validate OTP is entered
        if (empty($this->otp) || strlen($this->otp) != 6) {
            $this->otpError = 'Please enter a valid 6-digit OTP';
            return;
        }

        // Check if OTP is valid
        $otpRecord = Otp::where('user_id', $this->id)
            ->where('otp', $this->otp)
            ->where('expire_at', '>=', now())
            ->where('verified_at', null)
            ->latest()
            ->first();

        if (!$otpRecord) {
            $this->otpError = 'Invalid or expired OTP. Please try again.';
            return;
        }

        // Mark OTP as used
        $otpRecord->update(['is_used' => 1 , 'verified_at' => now()]);


        // Proceed with the update based on type
        if ($this->updateType === 'profile') {
            $this->updatePersonalInformation();
        } elseif ($this->updateType === 'password') {
            $this->changePassword();
        }

        // Reset OTP verification state
        $this->showOtpVerification = false;
        $this->otp = '';
    }

    public function cancelOtpVerification()
    {
        $this->showOtpVerification = false;
        $this->otp = '';
        $this->otpError = '';
        $otpRecord = Otp::where('user_id', $this->id)
            ->where('otp', $this->otp)
            ->where('expire_at', '>=', now())
            ->where('verified_at', null)
            ->latest()
            ->first();
            if ($otpRecord) {
                $otpRecord->update([
                    'is_used' => true
                ]);
            }
    }

    public function updatePersonalInformation()
    {
        // Make sure email isn't changed
        $originalEmail = $this->user->email;
        $this->state['email'] = $originalEmail;

        $validateData = Validator::make($this->state, [
            'name' => 'required|min:3|string',
            'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no,' . $this->id,
            'address' => 'required',
            'state_name' => 'required',
            'city' => 'required|string',
            'pincode' => 'required|numeric|min_digits:6|digits:6',
        ])->validate();

        $user = $this->user->update([
            'name' => $validateData['name'],
            'mobile_no' => $validateData['mobile_no'],
            // Notice: email is not updated
        ]);

        if ($user) {
            if (auth()->user()->getRoleNames()->first() == 'api-partner') {
                ApiPartner::where('user_id', $this->id)->update([
                    'mobile_no' => $validateData['mobile_no'],
                    'state_id' => $validateData['state_name'],
                    'city' => $validateData['city'],
                    'pincode' => $validateData['pincode'],
                    'address' => $validateData['address'],
                ]);
            } else {
                Retailer::where('user_id', $this->id)->update([
                    'mobile_no' => $validateData['mobile_no'],
                    'state_id' => $validateData['state_name'],
                    'city' => $validateData['city'],
                    'pincode' => $validateData['pincode'],
                    'address' => $validateData['address'],
                ]);
            }

            // Set flash message directly using Session facade
            Session::flash('success', "Your personal information updated successfully!");

            // Force a page refresh to show the flash message
            return redirect(request()->header('Referer'));
        } else {
            Session::flash('error', "Your personal information was not updated. Please try again!");
            return redirect(request()->header('Referer'));
        }
    }

    public function changePassword()
    {
        $this->tab = "password manager";
        $validateData = Validator::make($this->password, [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8',
        ])->validate();

        if (!Hash::check($validateData['old_password'], $this->user->password)) {
            Session::flash('error', "Your old password doesn't match");
            return;
        }

        $changePassword = $this->user->update([
            'password' => Hash::make($validateData['confirm_password']),
        ]);

        if ($changePassword) {
            auth()->logout();
            // Set flash message and redirect
            Session::flash('success', "Your password has been changed. Please login now!");
            return redirect()->route('admin.login');
        } else {
            Session::flash('error', "Your password was not changed. Please try again.");
            return redirect(request()->header('Referer'));
        }
    }

    public function resendOtp()
    {
        // Mark previous OTPs as used
        Otp::where('user_id', $this->id)

            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Clear previous errors
        $this->otpError = '';

        // Generate and send new OTP
        $this->generateAndStoreOtp();

        // Add session flash message
        Session::flash('info', 'A new OTP has been sent to your mobile number.');
    }

    public function sendOtp()
    {
        // Send OTP via email
        ProfileUpdateOtpJob::dispatch($this->state['email'], $this->generatedOtp);
    }

    // Polling function to update timer every second
    public function getListeners()
    {
        return array_merge($this->listeners, [
            'echo:timer,TimerEvent' => '$refresh',
        ]);
    }

    // Calculate remaining time for display
    public function getFormattedTimeRemainingProperty()
    {
        $minutes = floor($this->otpTimeRemaining / 60);
        $seconds = $this->otpTimeRemaining % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    // Decrease timer by 1 second
    public function decreaseTimer()
    {
        if ($this->otpTimeRemaining > 0) {
            $this->otpTimeRemaining--;
        }
    }
}
