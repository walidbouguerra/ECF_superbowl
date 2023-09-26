import bcrypt
from models.model import Model


class CommentatorModel(Model):

    def login_verif(self, email, password):
        db = self.db
        cursor = db.cursor(dictionary=True)
        cursor.execute("SELECT * FROM user WHERE email = %s", (email,))
        user = cursor.fetchone()
        cursor.close()
        db.close()
        if user is not None:
            if bcrypt.checkpw(bytes(password, "utf8"), bytes(user['password'], "utf8")) and user['role'] == "commentator":
                return True
        else:
            return False
