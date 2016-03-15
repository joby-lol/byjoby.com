#!/bin/bash
DEST=$1
SOURCE=src/${DEST/build\/}
SOURCE=`echo $SOURCE | sed -e 's/\.html$/\.*/g'`
echo processing $DEST

template="default"

# Parse YAML, using sed to replace  variables of the sort {{foo_bar}} with YAML foo.bar
# https://gist.github.com/pkuczynski/8665367
parse_yaml() {
   local prefix=$2
   local s='[[:space:]]*' w='[a-zA-Z0-9_]*' fs=$(echo @|tr @ '\034')
   sed -ne "s|^\($s\)\($w\)$s:$s\"\(.*\)\"$s\$|\1$fs\2$fs\3|p" \
        -e "s|^\($s\)\($w\)$s:$s\(.*\)$s\$|\1$fs\2$fs\3|p"  $1 |
   awk -F$fs '{
      indent = length($1)/2;
      vname[indent] = $2;
      for (i in vname) {if (i > indent) {delete vname[i]}}
      if (length($3) > 0) {
         vn=""; for (i=0; i<indent; i++) {vn=(vn)(vname[i])("_")}
         printf("%s%s%s=\"%s\" && sed -i \"s/{{%s%s%s}}/${%s%s%s}/g\" $DEST; \n", "'$prefix'", vn, $2, $3, "'$prefix'", vn, $2, "'$prefix'", vn, $2);
      }
   }'
}

# Parse metayaml file if it exists
if [ -f "${DEST}.metayaml" ];
then
    eval $(parse_yaml "${DEST}.metayaml")
fi

if [ -f "templates/${template}.html" ];
then
  TMPFILE=".template"
  cp "templates/${template}.html" $TMPFILE
  # sed -e '/{{template_body}}/{r $DEST' -e 'd}' $TMPFILE
  sed -i "s/{{template_body}}/$(sed -e 's/[\&/]/\\&/g' -e 's/$/\\n/' $DEST | tr -d '\n')/" $TMPFILE
  cp $TMPFILE $DEST
  # Parse metayaml file if it exists
  # Ugly and inefficient to do it twice, but it kind of needs to be done
  if [ -f "${DEST}.metayaml" ];
  then
      eval $(parse_yaml "${DEST}.metayaml")
  fi
fi

# File build time - can be overridden by metadata
MTIME=`date -r $SOURCE`
sed -i "s/{{filemtime}}/$MTIME/g" $DEST

# File build time - can be overridden by metadata
BTIME=`date`
sed -i "s/{{filebtime}}/$BTIME/g" $DEST

# Also parse the main site-wide yaml file
eval $(parse_yaml meta.yaml)

#remove metayaml file
if [ -f "${DEST}.metayaml" ];
then
    rm "${DEST}.metayaml"
fi
if [ -f ".template" ];
then
    rm ".template"
fi
