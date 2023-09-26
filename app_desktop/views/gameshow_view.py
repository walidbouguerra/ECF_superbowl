from tkinter import *
from models.game_model import GameModel
from tkinter import messagebox


def game_show_frame(game_frame, id_game):
    for f in game_frame.winfo_children():
        f.destroy()
    game_frame.pack()

    model = GameModel()

    def close_game():
        model.close_game(id_game)
        messagebox.showwarning("Match terminé", "Le match est clos.")

    game = model.find_one_game(id_game)
    comments = model.find_comments(id_game)
    bets_nb1 = str(model.find_bets_nb(id_game, game["id_team1"]))
    bets_nb2 = str(model.find_bets_nb(id_game, game["id_team2"]))
    t1_name = game['t1_name']
    start_date = str(game['start_date'])
    end_date = str(game['end_date'])
    score1 = str(game['score_1'])
    odds1 = str(game['odds_1'])

    t2_name = game['t2_name']
    score2 = str(game['score_2'])
    odds2 = str(game['odds_2'])

    start_date_label = Label(game_frame, text="Début : " + start_date, font="bold")
    start_date_label.grid(row=0, column=0)

    end_date_label = Label(game_frame, text="Fin : " + end_date, font="bold")
    end_date_label.grid(row=0, column=2)

    t1_name_label = Label(game_frame, text=t1_name, fg='#FF6666')
    t1_name_label.grid(row=1, column=0)

    odds1_label = Label(game_frame, text="Cote : " + odds1)
    odds1_label.grid(row=2, column=0)

    score1_label = Label(game_frame, text="Score : " + score1)
    score1_label.grid(row=3, column=0)

    bets_nb1_label = Label(game_frame, text="Nombre de paris : " + bets_nb1)
    bets_nb1_label.grid(row=4, column=0)

    comment_label = Label(game_frame, text="Commentaires :")
    comment_label.grid(row=1, column=1)

    comments_list = Listbox(game_frame)
    comments_list.configure(font=("Arial", 12), width=0, height=0)
    comments_list.grid(row=2, column=1)
    for comment in comments:
        comments_list.insert('end', comment['text'])

    t2_name_label = Label(game_frame, text=t2_name, fg='#FF6666')
    t2_name_label.grid(row=1, column=2)

    odds2_label = Label(game_frame, text="Cote : " + odds2)
    odds2_label.grid(row=2, column=2)

    score2_label = Label(game_frame, text="Score : " + score2)
    score2_label.grid(row=3, column=2)

    bets_nb2_label = Label(game_frame, text="Nombre de paris : " + bets_nb2)
    bets_nb2_label.grid(row=4, column=2)

    close_button = Button(game_frame, text="Clore le match", font=("bold", 14), fg='#FF6666', command=close_game)
    close_button.grid(row=5, column=1)
    close_label = Label(game_frame, text="Match terminé")
    close_label.grid(row=5, column=1)

    if len(end_date) > 4:
        close_button.destroy()
    else:
        close_label.destroy()

    for widget in game_frame.winfo_children():
        widget.grid_configure(padx=5, pady=5)
