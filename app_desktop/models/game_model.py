from models.model import Model
from datetime import datetime, date


class GameModel(Model):

    def find_all_games(self):
        db = self.db
        today = str(date.today())
        cursor = db.cursor(dictionary=True)
        cursor.execute(("SELECT game.id_game, t1.name AS t1_name, t2.name AS t2_name, "
                        "DATE_FORMAT(start_time, '%Hh%i') AS start_date, "
                        "DATE_FORMAT(end_time, '%Hh%i') AS end_date "
                        "FROM game "
                        "JOIN team t1 ON game.id_team1 = t1.id_team "
                        "JOIN team t2 ON game.id_team2 = t2.id_team WHERE DATE(start_time) = %s"), (today,))
        games = cursor.fetchall()
        cursor.close()
        db.close()
        return games

    def find_one_game(self, id_game):
        db = self.db
        cursor = db.cursor(dictionary=True)
        cursor.execute(("SELECT *, game.id_game, t1.name AS t1_name, t2.name AS t2_name, "
                        "DATE_FORMAT(start_time, '%Hh%i') AS start_date, "
                        "DATE_FORMAT(end_time, '%Hh%i') AS end_date "
                        "FROM game "
                        "JOIN team t1 ON game.id_team1 = t1.id_team "
                        "JOIN team t2 ON game.id_team2 = t2.id_team WHERE id_game = %s"), (id_game,))
        game = cursor.fetchone()
        cursor.close()
        return game

    def find_bets_nb(self, id_game, id_team):
        db = self.db
        cursor = db.cursor(dictionary=True)
        cursor.execute("SELECT COUNT(id_bet) as bets_nb FROM bet WHERE id_game = %s AND id_team = %s", (id_game, id_team))
        nb = cursor.fetchone()
        nb = nb['bets_nb']
        cursor.close()
        return nb

    def find_comments(self, id_game):
        db = self.db
        cursor = db.cursor(dictionary=True)
        cursor.execute("SELECT *  FROM comment WHERE id_game = %s ", (id_game,))
        comments = cursor.fetchall()
        cursor.close()
        return comments

    def close_game(self, id_game):
        db = self.db
        today = str(datetime.today())
        cursor = db.cursor(dictionary=True)
        cursor.execute("UPDATE game SET end_time = %s WHERE id_game = %s", (today, id_game))
        cursor.execute("SELECT * FROM game WHERE id_game = %s", (id_game,))
        game = cursor.fetchone()
        cursor.execute("SELECT * FROM bet WHERE id_game = %s", (id_game,))
        bets = cursor.fetchall()
        for bet in bets:
            if game['score_1'] > game['score_2']:
                id_team = game['id_team1']
                odds = game['odds_1']
            else:
                id_team = game['id_team2']
                odds = game['odds_2']
            if bet['id_team'] == id_team:
                cursor.execute("UPDATE bet SET profits = %s WHERE id_bet = %s", (bet['amount'] * odds, bet['id_bet']))
            else:
                cursor.execute("UPDATE bet SET losses = %s WHERE id_bet = %s", (0 - bet['amount'], bet['id_bet']))
        db.commit()
