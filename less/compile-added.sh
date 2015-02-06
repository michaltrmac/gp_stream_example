#/bin/bash

echo "Compile added less files"

cd less-added

for FILE in *.less
do
	echo "Compile $FILE ..."
	recess --compile $FILE > ../../public_html/css/${FILE%.less}.css
done

#cd ../less-mobile

#for FILE in *.less
#do
#	echo "Compile $FILE ..."
#	recess --compile $FILE > ../../public_html/css/mobile/${FILE%.less}.css
#done

echo "Finished"