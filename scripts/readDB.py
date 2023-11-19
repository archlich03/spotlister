import os
import time
import mysql.connector
import re

def get_last_scan(cursor):
    cursor.execute("SELECT lastScan FROM ScanData")
    result = cursor.fetchone()
    
    if result is None:
        cursor.execute("INSERT INTO ScanData (lastScan) VALUES (%s)", (int(time.time()),))
        cursor.execute("SELECT lastScan FROM ScanData")
        result = cursor.fetchone()
        
    return result


def initialize_database():
    conn = mysql.connector.connect(
        host= "localhost",
        user="spotlister",
        password="test",
        database="spotlister"
    )
    return conn
def process_playlists(cursor, conn, last_scan):
    timestamp = time.time()
    print(f"[{timestamp}] Beginning the reading of all inserted entries.")

    cursor.fetchall()

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

    cursor.execute("UPDATE ScanData SET lastScan = %s", (int(time.time()),))
    conn.commit()

    print(f"[{timestamp}] Finished reading all inserted entries.")
def main():
    conn = initialize_database()
    cursor = conn.cursor()
    
    last_scan = get_last_scan(cursor)[0]

    process_playlists(cursor, conn, last_scan)

    cursor.close()
    conn.close()

if __name__ == "__main__":
    main()