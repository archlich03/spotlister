import os
import time
import mysql.connector
import re
import glob

def get_last_scan(cursor):
    cursor.execute("SELECT lastScan FROM ScanData")
    result = cursor.fetchone()
    
    if result is None:
        cursor.execute("INSERT INTO ScanData (lastScan) VALUES (%s)", (int(time.time()),))
        cursor.execute("SELECT lastScan FROM ScanData")
        result = cursor.fetchone()
        
    return result


def initialize_database():
    try:
        conn = mysql.connector.connect(
            host= "localhost",
            user="spotlister",
            password="password",
            database="spotlister"
        )
        return conn
    except Exception as e:
        print(e)
        exit(1)

def get_spotdl_executable():
    matching_files = glob.glob("scripts/spotdl*")
    if matching_files:
         return os.path.basename(matching_files[0])
    else:
        return None

def process_playlists(cursor, conn, last_scan, spotdl_executable):
    timestamp = time.time()
    print(f"[{timestamp}] Beginning the reading of all inserted entries.")

    cursor.execute("SELECT * FROM Playlists")
    playlists = cursor.fetchall()
    print(f"[{timestamp}] Found {len(playlists)} playlists.")

    for playlist in playlists:
        id, url, frequency, last_download, _ = playlist

        if frequency == -1:
            print(f"[{timestamp}] Removing {url} (frequency = -1).")
            cursor.execute("DELETE FROM Playlists WHERE id = %s", (id,))
        else:
            if last_download + frequency * 3600 <= last_scan:
                print(f"[{timestamp}] Downloading {url}")
                os.chdir("scripts")
                os.system(f"./{spotdl_executable} download {url}")
                os.chdir("..")
                cursor.execute("UPDATE Playlists SET lastDownload = %s WHERE id = %s", (int(time.time()), id))
                conn.commit()

                print(f"[{timestamp}] {url} finished downloading.")
            else:
                print(f"[{timestamp}] Skipping {url} due to the refresh time coming later.")

    cursor.execute("UPDATE ScanData SET lastScan = %s", (int(time.time()),))
    conn.commit()

    print(f"[{timestamp}] Finished reading all inserted entries.")
def main():
    conn = initialize_database()
    cursor = conn.cursor()
    
    last_scan = get_last_scan(cursor)[0]

    spotdl_executable = get_spotdl_executable()

    if spotdl_executable:
        print(f"spotdl executable found: {spotdl_executable}")
        process_playlists(cursor, conn, last_scan, spotdl_executable)
    else:
        print("spotdl executable not found.")

    cursor.close()
    conn.close()

if __name__ == "__main__":
    main()