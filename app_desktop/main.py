from tkinter import *
from tkinter import messagebox
from models.commentator_model import CommentatorModel
from views.gamelist_view import games_frame


def delete_pages():
    for f in frame.winfo_children():
        f.destroy()


def login():
    # Récupération des informations de connexion puis les vérifier
    email = emailEntry.get()
    password = passwordEntry.get()
    if email == "" or password == "":
        messagebox.showwarning("Erreur", "Veuillez remplir tous les champs.")
    else:
        model = CommentatorModel()
        if model.login_verif(email, password):
            delete_pages()
            games_frame(frame)
        else:
            messagebox.showwarning("Erreur", "Votre e-mail ou mot de passe sont incorrects.")


# Configuration de la fenêtre
window = Tk()
window.geometry("800x600")
window.title("Superbowl")

# Cadre principal
frame = Frame(window, bg='#4682B4')
frame.pack(fill=BOTH, expand=1)

# Cadre de connexion
loginFrame = LabelFrame(frame, text="Connexion", font=("Arial", 16), bg='#4682B4', fg='white')
loginFrame.pack(padx=100, pady=100)

# E-mail
emailLabel = Label(loginFrame, text="E-mail :", font=("Arial", 16), bg='#4682B4', fg='white')
emailLabel.grid(row=0, column=0)
emailEntry = Entry(loginFrame, width=50)
emailEntry.grid(row=0, column=1, columnspan=5)

# Mot de passe
passwordLabel = Label(loginFrame, text="Mot de passe :", font=("Arial", 16), bg='#4682B4', fg='white')
passwordLabel.grid(row=1, column=0)
passwordEntry = Entry(loginFrame, show="*", width=50)
passwordEntry.grid(row=1, column=1)

# Bouton de connexion
loginButton = Button(loginFrame, command=login, text="Se connecter", font=("Arial", 16, "bold"), bg='white',
                     fg='#4682B4')
loginButton.grid(row=2, column=0, columnspan=2)

# Espacement des widgets
for widget in loginFrame.winfo_children():
    widget.grid_configure(padx=10, pady=15)

# Lancement de l'application
window.mainloop()
