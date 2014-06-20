#!/bin/sh

host="localhost"
db="bsi"
usr="root"
pwd="mysql"

echo "drop database bsi; create database bsi;" | /usr/bin/mysql -uroot -pmysql

perl author_bulletin.pl $host $db $usr $pwd
perl author_fli.pl $host $db $usr $pwd
perl author_s1.pl $host $db $usr $pwd
perl author_s2.pl $host $db $usr $pwd
perl author_s3.pl $host $db $usr $pwd
perl author_s4.pl $host $db $usr $pwd
perl author_records.pl $host $db $usr $pwd
perl author_vnv.pl $host $db $usr $pwd

perl feat_bulletin.pl $host $db $usr $pwd
perl articles_bulletin.pl $host $db $usr $pwd

perl feat_records.pl $host $db $usr $pwd
perl articles_records.pl $host $db $usr $pwd

perl books_fli.pl $host $db $usr $pwd
perl toc_fli.pl $host $db $usr $pwd

perl books_s1.pl $host $db $usr $pwd
perl toc_s1.pl $host $db $usr $pwd

perl books_s2.pl $host $db $usr $pwd
perl toc_s2.pl $host $db $usr $pwd

perl books_s3.pl $host $db $usr $pwd
perl toc_s3.pl $host $db $usr $pwd

perl books_s4.pl $host $db $usr $pwd
perl toc_s4.pl $host $db $usr $pwd

perl books_vnv.pl $host $db $usr $pwd
perl toc_vnv.pl $host $db $usr $pwd

perl ocr_bulletin.pl $host $db $usr $pwd
perl ocr_fli.pl $host $db $usr $pwd
perl ocr_s1.pl $host $db $usr $pwd
perl ocr_s2.pl $host $db $usr $pwd
perl ocr_s3.pl $host $db $usr $pwd
perl ocr_s4.pl $host $db $usr $pwd
perl ocr_records.pl $host $db $usr $pwd
perl ocr_vnv.pl $host $db $usr $pwd

perl searchtable_bulletin.pl $host $db $usr $pwd
perl searchtable_fli.pl $host $db $usr $pwd
perl searchtable_s1.pl $host $db $usr $pwd
perl searchtable_s2.pl $host $db $usr $pwd
perl searchtable_s3.pl $host $db $usr $pwd
perl searchtable_s4.pl $host $db $usr $pwd
perl searchtable_records.pl $host $db $usr $pwd
perl searchtable_vnv.pl $host $db $usr $pwd

echo "create fulltext index text_index_bulletin on searchtable_bulletin (text);" | /usr/bin/mysql -uroot -pmysql bsi
echo "create fulltext index text_index_fli on searchtable_fli (text);" | /usr/bin/mysql -uroot -pmysql bsi
echo "create fulltext index text_index_s1 on searchtable_s1 (text);" | /usr/bin/mysql -uroot -pmysql bsi
echo "create fulltext index text_index_s2 on searchtable_s2 (text);" | /usr/bin/mysql -uroot -pmysql bsi
echo "create fulltext index text_index_s3 on searchtable_s3 (text);" | /usr/bin/mysql -uroot -pmysql bsi
echo "create fulltext index text_index_s4 on searchtable_s4 (text);" | /usr/bin/mysql -uroot -pmysql bsi
echo "create fulltext index text_index_records on searchtable_records (text);" | /usr/bin/mysql -uroot -pmysql bsi
echo "create fulltext index text_index_vnv on searchtable_vnv (text);" | /usr/bin/mysql -uroot -pmysql bsi
