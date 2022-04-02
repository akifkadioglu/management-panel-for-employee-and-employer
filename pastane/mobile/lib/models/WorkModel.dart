import 'dart:convert';

List<WorkModel> workModelFromJson(String str) => List<WorkModel>.from(json.decode(str).map((x) => WorkModel.fromJson(x)));

String workModelToJson(List<WorkModel> data) => json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class WorkModel {
    WorkModel({
        required this.id,
        required this.userId,
        required this.start,
        required this.finish,
        required this.createdAt,
        required this.updatedAt,
        required this.user,
    });

    int id;
    int userId;
    String start;
    String finish;
    DateTime createdAt;
    DateTime updatedAt;
    User user;

    factory WorkModel.fromJson(Map<String, dynamic> json) => WorkModel(
        id: json["id"],
        userId: json["user_id"],
        start: json["start"],
        finish: json["finish"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        user: User.fromJson(json["user"]),
    );

    Map<String, dynamic> toJson() => {
        "id": id,
        "user_id": userId,
        "start": start,
        "finish": finish,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "user": user.toJson(),
    };
}

class User {
    User({
        required this.id,
        required this.name,
        required this.createdAt,
        required this.updatedAt,
    });

    int id;
    String name;
    DateTime createdAt;
    DateTime updatedAt;

    factory User.fromJson(Map<String, dynamic> json) => User(
        id: json["id"],
        name: json["name"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
    );

    Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
    };
}
