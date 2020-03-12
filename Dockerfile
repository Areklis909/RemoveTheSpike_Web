FROM areklis909/remove_the_spike:0.0.1

ENV USR root

USER $USR

ENV SERVER_DIR /var/www/html

WORKDIR $SERVER_DIR

ENV LOGS_DIR logs
ENV PIDS_DIR pids
ENV UPLOADS_DIR uploads
ENV PROCESSED_DIR processed
ENV CHARTS_DIR charts

RUN mkdir $LOGS_DIR \
    && mkdir $PIDS_DIR \
    && mkdir $UPLOADS_DIR  \
    && mkdir $PROCESSED_DIR \
    && mkdir $CHARTS_DIR	


COPY . $SERVER_DIR

ENV BINARY_DIR $SERVER_DIR/server/bin

RUN chown -R www-data:www-data $SERVER_DIR \
    && chmod 700 * && chmod 500 *.php \
    && chmod -R 500 css/ favicon/ img/ \
    && mkdir server/bin \
    && cp '~'/RemoveTheSpike_bin/* $BINARY_DIR \
    && rm -r '~'

ENV CRON_FILE /etc/cron.d/hello
ENV CRON_BINARY /usr/bin/crontab
ENV SCRIPT_TO_CALL $SERVER_DIR/scripts/clear_old_files
ENV LOG_FILE_LIFETIME_IN_HOURS 48

RUN touch $CRON_FILE && touch /var/log/cronlog \
 # && echo '* * * * * python3 /var/www/html/scripts/clear_old_files /var/www/html/logs 1 --minutes' > $CRON_FILE \
   && echo -n '0 0' >> $CRON_FILE \
   && echo -n ' * * * ' >> $CRON_FILE \
   && echo -n python3 >> $CRON_FILE \
   && echo -n ' ' >> $CRON_FILE \
   && echo -n $SCRIPT_TO_CALL >> $CRON_FILE \
   && echo -n ' ' >> $CRON_FILE \
   && echo -n $SERVER_DIR >> $CRON_FILE \
   && echo -n / >> $CRON_FILE \
   && echo -n $LOGS_DIR >> $CRON_FILE \
   && echo -n ' ' >> $CRON_FILE \
   && echo -n $LOG_FILE_LIFETIME_IN_HOURS >> $CRON_FILE \
   && echo -n ' ' >> $CRON_FILE \   
   #&& echo -n  '> /dev/null 2>&1' >> $CRON_FILE \
   && echo '\n' >> $CRON_FILE \
   && $CRON_BINARY $CRON_FILE

CMD sh $SERVER_DIR/start.sh
