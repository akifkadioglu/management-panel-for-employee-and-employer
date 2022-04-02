import 'package:flutter/material.dart';
import 'package:mobile/scenes/Home.dart';
import 'package:mobile/scenes/Loading.dart';

void main(List<String> args) {
  return runApp(MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      
      debugShowCheckedModeBanner: false,
      title: 'Çamlıca Pastanesi',
      home: Home(),
    );
  }
}
