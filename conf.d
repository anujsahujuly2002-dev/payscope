[program:email-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/groscope/artisan queue:work 
autostart=true
autorestart=true
user=forge
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/groscope/storage/logs/supervisord.log
