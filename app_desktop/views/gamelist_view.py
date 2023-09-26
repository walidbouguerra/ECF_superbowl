from tkinter import *
from models.game_model import GameModel
from views.gameshow_view import game_show_frame


def games_frame(frame):

    def show(e):
        for i in games_list.curselection():
            game_show_frame(game_frame, games_id[i])

    model = GameModel()
    games = model.find_all_games()
    games_id = []

    games_list_frame = LabelFrame(frame, text="Matchs du jour", font=("Arial", 16), bg='#4682B4', fg='white')
    games_list_frame.pack(padx=100, pady=(100, 50))
    games_list = Listbox(games_list_frame)
    for game in games:
        games_id.append(game['id_game'])
        games_list.insert('end', game['t1_name'] + ' vs ' + game['t2_name'] + " - Début :" + str(game['start_date']) + " - Fin :" + str(game['end_date']))
    games_list.bind("<<ListboxSelect>>", show)
    games_list.configure(font=("Arial", 12), width=0, height=0)
    games_list.pack(padx=10, pady=15)

    game_frame = LabelFrame(frame, text="Détails", font=("Arial", 16), bg='#4682B4', fg='white')
