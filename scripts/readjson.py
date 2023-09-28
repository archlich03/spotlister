import json
import os
import time

def write_data():
    with open('job.json', 'w') as json_file:
        json.dump(data, json_file, indent=4)

file = open('job.json')
data = json.load(file)

lastScan = data['lastScan']

kept_data = []

for entry in data['data']:
    url = entry['url']
    frequency = entry['frequency']
    lastDownload = entry['lastDownload']

    if(frequency == -1):
        print(f"Removing {url}")
    else:
        if (lastDownload + frequency * 3600 <= lastScan):
            print(f"Downloading {url}")
            os.system(f"./spotdl-4.2.0-linux download {url}")

            entry['lastDownload'] = int(time.time())
            write_data()
            print(f"{url} downloaded")
        else:
            print(f"Skipping {url}")

        kept_data.append(entry)
    
data['data'] = kept_data
data['lastScan'] = int(time.time())

write_data()
file.close()