import os
import shutil
from mutagen.easyid3 import EasyID3

def organize(input_folder, output_folder):
    if not os.path.exists(output_folder):
        os.makedirs(output_folder)

    for root, dirs, files in os.walk(input_folder):
        for file in files:
            if file.lower().endswith(('.mp3', '.ogg', '.flac')):
                file_path = os.path.join(root, file)
                audiofile = EasyID3(file_path)

                if 'artist' in audiofile and 'album' in audiofile:
                    artist_name = audiofile['artist'][0].split(',')[0].strip()
                    album_name = audiofile['album'][0]

                    artist_folder = os.path.join(output_folder, artist_name)
                    if not os.path.exists(artist_folder):
                        os.makedirs(artist_folder)

                    if album_name:
                        album_folder = os.path.join(artist_folder, album_name)
                    else:
                        album_folder = os.path.join(artist_folder, "unsorted")

                    if not os.path.exists(album_folder):
                        os.makedirs(album_folder)

                    output_file_path = os.path.join(album_folder, file)

                    if file_path != output_file_path:
                        if not os.path.exists(output_file_path):
                            shutil.copy2(file_path, output_file_path)
                            print(f"Moved '{file}' to '{artist_name}/{album_name}' folder.")
                        else:
                            print(f"Skipped '{file}' as it's already in the correct folder.")
                            os.remove(file_path)
                else:
                    print(f"Skipped '{file}' as it doesn't have complete artist metadata.")

if __name__ == "__main__":
    input_folder = "/home/muzikantas/unsorted"
    output_folder = "/home/muzikantas/music"
    organize(input_folder, output_folder)

