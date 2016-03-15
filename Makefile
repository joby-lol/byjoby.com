all: build

copyfiles:
	find src -type f -regextype posix-egrep -iregex ".*\.(css|js|gif|jpe?g|png)" -exec ./scripts/copytocontent.sh {} \;

buildmd:
	find src -type f -iname "*.md" -exec ./scripts/buildmdfile.sh {} \;

buildhtml:
	find src -type f -iname "*.html" -exec ./scripts/buildhtmlfile.sh {} \;

processhtml:
	find build -type f -regextype posix-egrep -iregex ".*\.html?" -exec ./scripts/processhtmlfile.sh {} \;

build: copyfiles buildhtml buildmd processhtml

init:
	git ftp init

clean:
	rm -rf build/*
