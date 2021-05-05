# REST API Documentation


## GET `/categories`

Get all the categories

```json
{
    "categories": [
        {
            "id": 1,
            "name": "Books",
            "icon": "books.jpg"
        }
    ]
}
```


## POST `/hobbies/add`

Add a hobby

### Request

```json
{
    "categoryId": 2,
    "title": "Book XXX from YYY",
    "description": "Blabla blabla",
    "rating": 2,
    "photo": "binary_base64_image_data"
}
```

### Response

```json
{}
```


## GET `/users/{username}`

Return user's info + his/her latest hobbies.  
Add `?page=2` to list hobbies from the second page.

```json
{
    "user": {
        "id": 4,
        "name": "Liping",
        "nickname": "Lime",
        "avatar": "photo.jpg",
        "followers": 200,
        "following": 30,
    },
    "hobbies": [
        {
            "id": 1,
            "title": "Book XXX from YYY",
            "author": {
                "id": 4,
                "name": "Liping",
                "nickname": "Lime",
                "avatar": "photo.jpg"
            },
            "date": 1596895089,
            "category_id": 1,
            "description": "Blabla blabla",
            "photos": ["a.jpg", "b.jpg"],
            "rating": 8,
            "commentsNb": 3
        }
    ],
    "pagination": {
        "curPage": 1,
        "totalPages": 30
    }
}
```


## PUT `/users/me`

Edit oneself's info

```json
{
    "name": "Liping",
    "nickname": "Lime",
    "email": "lime@ema.il",
    "password": "encrypted_password",
    "avatar": "photo.jpg"
}
```


## POST `/users/{id}/follow`

Follow a user

### Request

```json
```

### Response

```json
```


## POST `/users/{id}/unfollow`

### Response

```json
```

## GET `/users/{id}/followers`

Get all the followers

```json
{
    "user": {
        "id": 4,
        "name": "Liping",
        "nickname": "Lime",
        "avatar": "photo.jpg"
    },

    "followers": [
        {
            "id": 4,
            "name": "Liping",
            "nickname": "Lime",
            "avatar": "photo.jpg"
        }
    ]
}
```

## GET `/users/{id}/following`

Get all the people a given user follows

```json
{
    "user": {
        "id": 4,
        "name": "Liping",
        "nickname": "Lime",
        "avatar": "photo.jpg"
    },

    "following": [
        {
            "id": 4,
            "name": "Liping",
            "nickname": "Lime",
            "avatar": "photo.jpg"
        }
    ]
}
```


## GET `/hobbies/latest`

Return the latest 30th posts from people you follow.  
Add `?page=2` to list hobbies from the second page.

```json
{
    "hobbies": [
        {
            "id": 1,
            "title": "Book XXX from YYY",
            "date": 1596895089,
            "author": {
                "id": 4,
                "name": "Liping",
                "nickname": "Lime",
                "avatar": "photo.jpg"
            },
            "category_id": 1,
            "description": "Blabla blabla",
            "photos": ["a.jpg", "b.jpg"],
            "rating": 8,
            "commentsNb": 3
        }
    ],
    "pagination": {
        "curPage": 1,
        "totalPages": 30
    }
}
```


## GET `/hobbies/{id}/comments`

Return all the comments of a given hobby.  
Add `?page=2` to list comments from the second page.

```json
{
    "comments":[
        {
          "id": 1,
          "author": {
              "id": 4,
              "name": "Liping",
              "nickname": "Lime",
              "avatar": "photo.jpg"
          },
          "content": "commentaire1"
        },
        ...
    ],
    "pagination": {
        "curPage": 1,
        "totalPages": 30
    }
}
```


## POST `/hobbies/{id}/comment`

Add a comment on a hobby

### Request

```json
{
    "content": "commentaire1"
}
```


## GET `/categories/{id}/hobbies`

Return the latest 30th posts of a given category.  
Add `?page=2` to list hobbies from the second page.

```json
{
    "category": {
        "id": 1,
        "name": "Books",
        "icon": "books.jpg"
    },
    "hobbies": [
        {
            "id": 1,
            "title": "Book XXX from YYY",
            "date": 1596895089,
            "author": {
                "id": 4,
                "name": "Liping",
                "nickname": "Lime",
                "avatar": "photo.jpg"
            },
            "category_id": 1,
            "description": "Blabla blabla",
            "photos": ["a.jpg", "b.jpg"],
            "rating": 8,
            "commentsNb": 3
        }
    ],
    "pagination": {
        "curPage": 1,
        "totalPages": 30
    }
```


## GET `/admin/users`

**Admin only**  

Return an array containing all the users.  
Add `?page=2` to list users from the second page.

```json
{
    "users": [
        {
            "id": 4,
            "name": "Liping",
            "nickname": "Lime",
            "email": "zzz@zzz.fr",
            "avatar": "photo.jpg",
            "is_admin": true
        }
    ],

    "pagination": {
        "curPage": 1,
        "totalPages": 30
    }
}
```


## PUT `/admin/users/{id}/edit`

Update a user with given values

### Request

```json
{
    "id": 4,
    "name": "Liping",
    "nickname": "Lime",
    "email": "zzz@zzz.fr",
    "avatar": "binary_base64_image_data",
    "is_admin": true
}
```


## DELETE `/admin/users/{id}/delete`

Delete a given user

### Response

```json
```
