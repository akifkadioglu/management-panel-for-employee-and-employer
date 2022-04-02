import 'dart:convert';

import 'package:date_time_picker/date_time_picker.dart';
import 'package:dropdown_below/dropdown_below.dart';
import 'package:flutter/material.dart';
import 'package:mobile/constant.dart';
import 'package:http/http.dart' as http;
import 'package:mobile/models/WorkModel.dart';
import 'package:time_range/time_range.dart';

import '../models/ApiResponse.dart';
import '../models/UserModel.dart';

class Home extends StatefulWidget {
  const Home({Key? key}) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  List<UserModel> _testList = [];
  List allWorkList = [];
  List<DropdownMenuItem<Object?>> _dropdownTestItems = [];
  var _selectedUser;
  dynamic _start;
  dynamic _finish;
  String publicMessage = "";
  getMessage() async {
    var localMessage = await http.get(
      Uri.parse(message),
    );

    setState(() {
      this.publicMessage = localMessage.body;
    });
  }

  getUserList() async {
    var object = await http.get(
      Uri.parse(userList),
    );

    setState(() {
      _dropdownTestItems =
          buildDropdownTestItems(userModelFromJson(object.body));
    });
  }

  getWorkList() async {
    var object = await http.get(
      Uri.parse(workList),
    );
    _AddList(workModelFromJson(object.body) as List<WorkModel>);
  }

  void _AddList(List<WorkModel> works) async {
    if (this.mounted) {
      setState(() {
        allWorkList = works
            .map((e) => Card(
                    child: ListTile(
                  title: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Row(
                        children: [
                          Text(e.user.name),
                        ],
                      ),
                      Row(
                        children: [
                          IconButton(
                            icon: Icon(
                              Icons.delete_outline,
                              color: Colors.red,
                            ),
                            onPressed: () => deleteWork(e.id),
                          ),
                        ],
                      ),
                    ],
                  ),
                  subtitle: Container(
                    margin: EdgeInsets.only(
                      top: 10,
                    ),
                    child: Column(
                      children: [
                        Row(
                          children: [
                            Expanded(
                              child: Column(
                                children: [
                                  Text('Başlangıç Saati'),
                                  Text(e.start.substring(0, 5)),
                                ],
                              ),
                            ),
                            Expanded(
                              child: Column(
                                children: [
                                  Text('Bitiş Saati'),
                                  Text(e.finish.substring(0, 5)),
                                ],
                              ),
                            )
                          ],
                        ),
                      ],
                    ),
                  ),
                )))
            .toList();
      });
    }
  }

  @override
  void initState() {
    getUserList();
    getMessage();
    _dropdownTestItems = buildDropdownTestItems(_testList);
    getWorkList();
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

  List<DropdownMenuItem<Object?>> buildDropdownTestItems(List _testList) {
    List<DropdownMenuItem<Object?>> items = [];
    for (var i in _testList) {
      items.add(
        DropdownMenuItem(
          value: i.id,
          child: Text('${i.name}'),
        ),
      );
    }
    return items;
  }

  onChangeDropdownTests(selectedTest) {
    setState(() {
      _selectedUser = selectedTest;
    });
  }

  saveWork() async {
    final body = jsonEncode({
      "user_id": _selectedUser,
      "start": _start,
      "finish": _finish,
    });
    var headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    var response =
        await http.post(Uri.parse(createWork), body: body, headers: headers);
    if (response.statusCode == 200) {
      getWorkList();
    }
  }

  deleteWork(id) async {
    final body = jsonEncode({"id": id});
    var headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    var response =
        await http.post(Uri.parse(deleteTheWork), body: body, headers: headers);
    if (response.statusCode == 200) {
      getWorkList();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      floatingActionButton: publicMessage == ""
          ? null
          : FloatingActionButton(
              onPressed: () {
                showDialog(
                    context: context,
                    builder: (context) {
                      return AlertDialog(
                        content: Text("$publicMessage"),
                      );
                    });
              },
              child: Icon(Icons.warning),
            ),
      appBar: AppBar(
        title: Center(
          child: Text("Çamlıca Pastanesi"),
        ),
      ),
      body: Container(
        margin: EdgeInsets.only(top: 20),
        child: Column(
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                DropdownBelow(
                  itemWidth: 200,
                  itemTextstyle: TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.w400,
                      color: Colors.black),
                  boxTextstyle: TextStyle(
                      fontSize: 14,
                      fontWeight: FontWeight.w400,
                      color: Color.fromARGB(137, 0, 0, 0)),
                  boxPadding: EdgeInsets.fromLTRB(13, 12, 13, 12),
                  boxWidth: 300,
                  boxHeight: 45,
                  boxDecoration: BoxDecoration(
                      color: Color.fromARGB(0, 255, 0, 0),
                      border: Border.all(width: 1, color: Colors.black)),
                  icon: Icon(
                    Icons.person,
                    color: Colors.black,
                  ),
                  hint: _selectedUser != null
                      ? Text('$_selectedUser')
                      : Text('Bir kişi seçiniz'),
                  value: _selectedUser,
                  items: _dropdownTestItems,
                  onChanged: onChangeDropdownTests,
                ),
              ],
            ),
            Container(
              margin: EdgeInsets.only(left: 20, right: 20),
              child: Row(
                children: [
                  Flexible(
                    flex: 3,
                    child: DateTimePicker(
                      type: DateTimePickerType.time,
                      timeLabelText: "Başlangıç",
                      onChanged: (val) => _start = val,
                      validator: (val) {
                        setState(() {
                          _start = val;
                        });

                        return null;
                      },
                      onSaved: (val) => _start = val,
                    ),
                  ),
                  Flexible(child: Container()),
                  Flexible(
                    flex: 3,
                    child: DateTimePicker(
                      type: DateTimePickerType.time,
                      timeLabelText: "Bitiş",
                      onChanged: (val) => {_finish = val},
                      validator: (val) {
                        setState(() {
                          _finish = val;
                        });
                        return null;
                      },
                      onSaved: (val) => _finish = val,
                    ),
                  ),
                ],
              ),
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _selectedUser != null && _start != null && _finish != null
                    ? Expanded(
                        child: Container(
                          margin: EdgeInsets.only(
                            left: 20,
                            right: 20,
                          ),
                          child: SizedBox(
                            height: 50,
                            child: ElevatedButton(
                              onPressed: saveWork,
                              child: Text('Kaydet'),
                            ),
                          ),
                        ),
                      )
                    : CircularProgressIndicator(
                        color: Color.fromARGB(115, 0, 0, 0),
                      ),
              ],
            ),
            Expanded(
              child: ListView.builder(
                  itemCount: allWorkList.length,
                  itemBuilder: (BuildContext context, int i) {
                    return ListTile(
                      title: allWorkList[i],
                    );
                  }),
            )
          ],
        ),
      ),
    );
  }
}

ListTile workListTile() {
  return ListTile(
    title: Text("asd"),
  );
}
