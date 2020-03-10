import os
import sys
import time
from stat import *

path = sys.argv[1]
older_then_in_hours = int(sys.argv[2])

older_then_in_seconds = older_then_in_hours
if '--minutes' in sys.argv:
    older_then_in_seconds = older_then_in_seconds * 60
elif '--hours' in sys.argv:
    older_then_in_seconds = older_then_in_seconds * 60 * 60
else:
    older_then_in_seconds = older_then_in_seconds * 60 * 60


files_in_directory = os.listdir(path)

for file in files_in_directory:
    fullpath = path + '/' + file
    file_metadata = os.stat(fullpath)
    last_access_time = file_metadata[ST_ATIME]
    if(time.time() - last_access_time > older_then_in_seconds):
        os.remove(fullpath)