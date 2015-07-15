#!/user/bin/env
# Python Course
# Section 8 - Item #9
#   DRILL: db - Python 3.4
#      This script is used to create a new pre-made content database for storing content
#
import sqlite3

def main():
    db = sqlite3.connect("premadecontent.db")
    db.execute('DROP TABLE IF EXISTS storage')
    db.execute('''CREATE TABLE storage (id INTEGER PRIMARY KEY,
                                        name TEXT,
                                        content TEXT)''')

if __name__ == "__main__": main()