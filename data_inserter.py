import csv
from mysql.connector import connect, Error
from getpass import getpass

try:
    with connect(
        host='localhost', 
        user=input('Enter SQL username: '),
        password=getpass('Enter SQL password: ')
    ) as connection:
        print(connection)

        connection.cursor().execute("USE gravesidesdb;")
        connection.commit()

        with open('BlockCenters.csv', newline='\n') as csvFile:
            reader = csv.reader(csvFile, delimiter=',')
            next(reader)
            for row in reader:
                block = int(row[0])
                lat = row[1]
                long = row[2]
                if len(lat) != 0 and len(long) != 0:
                    print(row)
                    insert_query = f"INSERT INTO block (idBlock, blockLatitude, blockLongitude) VALUES ({block}, {lat}, {long});"
                    with connection.cursor() as cursor:
                        cursor.execute(insert_query)
                        connection.commit()

except Error as e:
    print(e)