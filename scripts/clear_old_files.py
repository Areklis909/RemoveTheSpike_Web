import os
import sys
import time
from stat import *

path = sys.argv[1]
older_then_in_hours = int(sys.argv[2])
older_then_in_seconds = older_then_in_hours * 60

files_in_directory = os.listdir(path)

for file in files_in_directory:
    file_metadata = os.stat(file)
    last_access_time = file_metadata[ST_ATIME]
    if(time.time() - last_access_time > older_then_in_seconds):
        os.remove(path + '/' + file)