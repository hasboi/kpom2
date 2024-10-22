import csv
import time
from datetime import datetime

def hitung_suara():
    try:
        with open('voted.csv', newline='') as csvfile:
            reader = csv.DictReader(csvfile)

            jumlah_osis = [0, 0, 0] 
            jumlah_mps = [0, 0]
            jumlah_ldp = [0, 0]

            for row in reader:
                jumlah_osis[int(row['osis']) - 1] += 1
                jumlah_mps[int(row['mps']) - 1] += 1
                jumlah_ldp[int(row['ldp']) - 1] += 1

        return jumlah_osis, jumlah_mps, jumlah_ldp
    except Exception as e:
        print(f"Terjadi kesalahan saat membaca voted.csv: {e}")
        return [0, 0, 0], [0, 0], [0, 0]

def simpan_progress(nama_file, waktu, data):
    try:
        file_baru = False
        try:
            with open(nama_file, 'r'):
                pass
        except FileNotFoundError:
            file_baru = True

        with open(nama_file, 'a', newline='') as csvfile:
            writer = csv.writer(csvfile)

            if file_baru:
                if len(data) == 3:
                    writer.writerow(['waktu', 'pemilih paslon 1', 'pemilih paslon 2', 'pemilih paslon 3'])
                else:
                    writer.writerow(['waktu', 'pemilih paslon 1', 'pemilih paslon 2'])

            writer.writerow([waktu] + data)
            print(f"Progress disimpan ke {nama_file} pada {waktu}")
    except Exception as e:
        print(f"Terjadi kesalahan saat menyimpan ke {nama_file}: {e}")

def catat_progress():
    try:
        while True:
            sekarang = datetime.now().strftime('%H:%M')

            jumlah_osis, jumlah_mps, jumlah_ldp = hitung_suara()

            simpan_progress('progress-osis.csv', sekarang, jumlah_osis)
            simpan_progress('progress-mps.csv', sekarang, jumlah_mps)
            simpan_progress('progress-ldp.csv', sekarang, jumlah_ldp)

            print(f"\nProgress dicatat pada {sekarang}")
            print(f"OSIS: {jumlah_osis}")
            print(f"MPS: {jumlah_mps}")
            print(f"LDP: {jumlah_ldp}")
            
            time.sleep(60 * 2)

    except KeyboardInterrupt:
        print("\nProses dihentikan oleh pengguna. Keluar dari program.")
    except Exception as e:
        print(f"Terjadi kesalahan: {e}")

if __name__ == '__main__':
    catat_progress()
