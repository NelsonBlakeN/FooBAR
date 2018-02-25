import sys
import MySQLdb

class PythonAPI:
    def __init__(self):
        self.conn = MySQLdb.connect(host="database.cs.tamu.edu", user="blake.nelson", passwd="Tamu@2019", db="blake.nelson")

        self.cursor = self.conn.cursor()

    def execute(self, query=None):
        if query is None or query is "":
            return "Query was null. Exiting"

        self.cursor.execute(query)
        self.conn.commit()
        return self.cursor.fetchone()
