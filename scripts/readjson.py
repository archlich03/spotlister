import os
import time
import mysql.connector
import re

def get_last_scan(cursor):
    cursor.execute("SELECT lastScan FROM scanData")
    return cursor.fetchall()


def initialize_database():
    with open('conf.php', 'r') as conf_file:
        conf_content = conf_file.read()
    
    host_match = re.search(r"\$settings\['serverName'\]\s*=\s*'([^']+)'", conf_content)
    user_match = re.search(r"\$settings\['userName'\]\s*=\s*'([^']+)'", conf_content)
    password_match = re.search(r"\$settings\['password'\]\s*=\s*'([^']+)'", conf_content)
    db_name_match = re.search(r"\$settings\['dbName'\]\s*=\s*'([^']+)'", conf_content)

    conn = mysql.connector.connect(
        host=host_match.group(1),
        user=user_match.group(1),
        password=password_match.group(1),
        database=db_name_match.group(1)
    )
    return conn
def process_playlists(cursor):
    timestamp = time.time()
    print(f"[{timestamp}] Beginning the reading of all inserted entries.")

    cursor.execute("SELECT * FROM Playlists")
    playlists = cursor.fetchall()

    for playlist in playlists:
        id, url, frequency, last_download = playlist

        if frequency == -1:
            print(f"[{timestamp}] Removing {url} (frequency = -1).")
        else:
            if last_download + frequency * 3600 <= last_scan:
                print(f"[{timestamp}] Downloading {url}")
                os.system(f"./spotdl-4.2.0-linux download {url}.")

                cursor.execute("UPDATE Playlists SET lastDownload = %s WHERE id = %s", (int(time.time()), id))
                conn.commit()

                print(f"[{timestamp}] {url} finished downloading.")
            else:
                print(f"[{timestamp}] Skipping {url} due to the refresh time coming later.")

    cursor.execute("INSERT INTO scanData (lastScan) VALUES (%s)", (int(time.time()),))
    conn.commit()

    print(f"[{timestamp}] Finished reading all inserted entries.")
def main():
    conn = initialize_database()
    cursor = conn.cursor()
    
    last_scan = get_last_scan(cursor)

    process_playlists(cursor)

    cursor.close()
    conn.close()

if __name__ == "__main__":
    main()