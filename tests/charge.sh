#!/bin/bash

find ../public/users -mindepth 1 -maxdepth 1 -type d | while read dir; do 
    count=$(find "$dir" -type f -iname \*.jpg | wc -l)
    echo `du -sh $dir` ": $count files"
done

echo "--- 	Start 	$(date)		---"
time php ../phpic-daemon.php 2>&1
echo "--- 	End 	$(date) 	---"
