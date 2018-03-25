import sys
import MySQLdb

# Object-oriented implemementation of the Python API.
class PythonAPI:
    def __init__(self):
        self.test_count = 0
        pass

    # Insert a single person into the database
    def person_passed(self):
	    # query = "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES (CURRENT_TIME(), CURRENT_DATE(), CURRENT_DATE())"
	    # self.execute(query)
        self.test_count += 1
        print(self.test_count)

    # Execute a given query string
    # @params: query (string), the query to be executed
    # @returns: results (string), single result of query
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
            # Always close connection (on fail or success)
            conn.close()

        return results
