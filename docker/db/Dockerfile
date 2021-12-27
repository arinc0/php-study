FROM mysql:8.0

ENV MYSQL_DATABASE=database \
    MYSQL_USER=docker \
    MYSQL_PASSWORD=docker \
    MYSQL_ROOT_PASSWORD=root \
    TZ=Asia/Tokyo

COPY ./my.cnf /etc/mysql/conf.d/my.cnf

RUN mkdir /var/lib/mysql-files && \
    chmod 644 /etc/mysql/conf.d/my.cnf && \
    chmod 644 /var/lib/mysql-files

