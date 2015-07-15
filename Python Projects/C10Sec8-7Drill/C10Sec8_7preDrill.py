#!/user/bin/env
# Python Course
# Section 8 - Item #7
#   DRILL: functionality for File Transfer - Python 3.4
#       This script is used to create a new reference database for recording the timestamps of each
#         execution of the file check/transfer script
#
import sqlite3

def main():
    db = sqlite3.connect("references.db")
    db.execute('DROP TABLE IF EXISTS previousTxfr')
    db.execute('''CREATE TABLE previousTxfr (time REAL PRIMARY KEY,
                                            source VARCHAR,
                                            destination VARCHAR,
                                            numfiles INT)''')

if __name__ == "__main__": main()