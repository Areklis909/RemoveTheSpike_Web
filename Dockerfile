FROM areklis909/remove_the_spike:0.0.1

USER root 

ENV SERVER_DIR /var/www/html/

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

