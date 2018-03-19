import sys
import MySQLdb

class PythonAPI:
    def __init__(self):
        pass

    def person_passed(self):
	query = "INSERT INTO `blake.nelson`.`FieldData` (`id`, `time`) VALUES (NULL, CURRENT_TIMESTAMP)"
	self.execute(query)

    def execute(self, query=None):
        results = None
        conn = None

        # Sanitize input
        if query is None or query is "":
            return "Query was null. Exiting"
        try:
            # Make connection
            conn = MySQLdb.connect(host="database.cs.tamu.edu", user="blake.nelson", passwd="Tamu@2019", db="blake.nelson")
        except:
            return "Connection failed."

        try:
            # Execute query and commit changes (if any were made)
            with conn.cursor() as cursor:
                cursor.execute(query)
            conn.commit()

            # Obtain results
            results = cursor.fetchone()
        finally:
            conn.close()

        return results
