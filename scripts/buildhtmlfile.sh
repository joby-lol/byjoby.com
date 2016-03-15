#!/bin/bash
# Some code for splitting YAML front matter lifted from https://github.com/jekyll/jekyll-import/issues/138

SOURCE=$1
DEST=build/${SOURCE/src\/}
echo building html $SOURCE into $DEST

# Split file into YAML header and content
awk '/^\---$/ { if(++delim % 2 == 0) { next } } { file = sprintf("chunk%s.txt", int(delim / 2)); print > file; }' < $SOURCE

# copy by default
cd src
cp --parents ${1/src\/} ../build
cd ..

# Check for front matter
if [ -f chunk1.txt ];
then
    cp chunk1.txt $DEST
    cp chunk0.txt "${DEST}.metayaml"
    sed -i "s/^---$//g" "${DEST}.metayaml"
fi

# Remove temporary files
rm chunk*.txt
