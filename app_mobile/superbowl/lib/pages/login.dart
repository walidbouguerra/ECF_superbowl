import 'dart:async';
import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  Future getData() async {
    var url = "http://192.168.1.45/app_mobile/api/database.php";
    final response = await http.get(Uri.parse(url));
    var data = jsonDecode(response.body);
    print(data);
  }

  @override
  void initState() {
    super.initState();
    getData();
  }

  @override
  final _formKey = GlobalKey<FormState>();

  final emailController = TextEditingController();
  final passwordController = TextEditingController();

  Widget build(BuildContext context) {
    return Scaffold(
      body: Form(
        key: _formKey,
        child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
          Text(
            "Connexion",
            style: TextStyle(fontWeight: FontWeight.bold, fontSize: 24),
          ),
          SizedBox(height: 20),
          TextFormField(
            decoration: InputDecoration(
              labelText: "E-mail",
              border: OutlineInputBorder(),
            ),
            validator: (value) {
              if (value == null || value.isEmpty) {
                return "Veuillez entrer votre e-mail.";
              }
              return null;
            },
            controller: emailController,
          ),
          SizedBox(height: 10),
          TextFormField(
            obscureText: true,
            decoration: InputDecoration(
              labelText: "Password",
              border: OutlineInputBorder(),
            ),
            validator: (value) {
              if (value == null || value.isEmpty) {
                return "Veuillez entrer votre mot de passe.";
              }
              return null;
            },
            controller: passwordController,
          ),
          SizedBox(height: 10),
          SizedBox(
            width: double.infinity,
            height: 50,
            child: ElevatedButton(
              onPressed: () {
                if (_formKey.currentState!.validate()) {
                  final email = emailController.text;
                  final password = passwordController.text;
                  ScaffoldMessenger.of(context).showSnackBar(
                      const SnackBar(content: Text("Connexion...")));
                }
              },
              child: Text("Se connecter"),
            ),
          )
        ]),
      ),
    );
  }
}
