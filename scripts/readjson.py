import json
import os
import time

def write_data():
    with open('job.json', 'w') as json_file:
        json.dump(data, json_file, indent=4)

file = open('job.json')
timestamp = time.time()
data = json.load(file)

lastScan = data['lastScan']

kept_data = []

print(f"[{timestamp}] Beginning the reading of all inserted entries.")
for entry in data['data']:
    url = entry['url']
    frequency = entry['frequency']
    lastDownload = entry['lastDownload']

    if(frequency == -1):
        print(f"[{timestamp}] Removing {url} (frequency = -1).")
    else:
        if (lastDownload + frequency * 3600 <= lastScan):
            print(f"[{timestamp}] Downloading {url}")
            os.system(f"./spotdl-4.2.0-linux download {url}.")

            entry['lastDownload'] = int(time.time())
            write_data()
            print(f"[{timestamp}] {url} finished downloading.")
        else:
            print(f"[{timestamp}] Skipping {url} due to the refresh time coming later.")

        kept_data.append(entry)
    
data['data'] = kept_data
data['lastScan'] = int(time.time())

write_data()
file.close()
print(f"[{timestamp}] Finished reading all inserted entries.")