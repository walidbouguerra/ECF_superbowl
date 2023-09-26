import mysql.connector as mysql


class Model:

    def __init__(self):
        self.db = mysql.connect(host="localhost", user="root", password="", database="superbowl")
