import csv

def read_all_voters(file_path):
    all_voters = []
    with open(file_path, mode='r', newline='', encoding='utf-8') as file:
        reader = csv.DictReader(file)
        for row in reader:
            all_voters.append(row['nama'].strip())
    return all_voters

def read_voted_voters(file_path):
    voted_voters = []
    with open(file_path, mode='r', newline='', encoding='utf-8') as file:
        reader = csv.DictReader(file)
        for row in reader:
            voted_voters.append(row['nama'].strip())
    return voted_voters

def calculate_not_voted(all_voters_file, voted_file):
    all_voters = read_all_voters(all_voters_file)
    voted_voters = read_voted_voters(voted_file)
    
    not_voted = [name for name in all_voters if name not in voted_voters]
    
    total_voters = len(all_voters)
    total_voted = len(voted_voters)
    total_not_voted = len(not_voted)
    percentage_voted = (total_voted / total_voters) * 100
    
    print(f"Yang sudah memilih: {total_voted}/{total_voters} [{percentage_voted:.2f}%]")
    print(f'Yang belum memilih: {total_not_voted}')
    print("\nList nama-nama yang belum memilih:")
    for name in not_voted:
        print(f"- {name}")

all_voters_file = 'data.csv'
voted_file = 'csv/voted.csv'

calculate_not_voted(all_voters_file, voted_file)
