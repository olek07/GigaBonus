#!/bin/bash
PASSWORD=
HOST=localhost
USER=root
DATABASE=gigabonus
DB_FILE=dump.sql

EXCLUDED_TABLES=(
cache_md5params
cache_treelist
cf_cache_hash
cf_cache_hash_tags
cf_cache_imagesizes
cf_cache_imagesizes_tags
cf_cache_pages                             
cf_cache_pages_tags                        
cf_cache_pagesection                       
cf_cache_pagesection_tags                  
cf_cache_rootline                          
cf_cache_rootline_tags                     
cf_extbase_datamapfactory_datamap          
cf_extbase_datamapfactory_datamap_tags     
cf_extbase_object                          
cf_extbase_object_tags                     
cf_extbase_reflection                      
cf_extbase_reflection_tags                 
cf_extbase_typo3dbbackend_queries          
cf_extbase_typo3dbbackend_queries_tags
cf_extbase_typo3dbbackend_tablecolumns
cf_extbase_typo3dbbackend_tablecolumns_tags
)

IGNORED_TABLES_STRING=''
for TABLE in "${EXCLUDED_TABLES[@]}"
do :
   IGNORED_TABLES_STRING+=" --ignore-table=${DATABASE}.${TABLE}"
done

# echo "Dump structure"
# /opt/lampp/bin/mysqldump --host=${HOST} --user=${USER} --password=${PASSWORD} --single-transaction --no-data ${DATABASE} > ${DB_FILE}

echo "Dump content"
/opt/lampp/bin/mysqldump --host=${HOST} --user=${USER} --password=${PASSWORD} ${DATABASE} ${IGNORED_TABLES_STRING} > ../${DB_FILE}
