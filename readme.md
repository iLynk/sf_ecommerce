# Diagramme relationnel d'entités

```mermaid

erDiagram

    User{
        int id PK
        string(255) email
        string(255) password
        array role
        datetime createdAt
        datetime modifiedAt

    }

    Customer{
        int id PK
        string(255) lastname
        string(255) firstname
        string(255) phone
        datetime birthdateAt
    }

    CustomerAddress{
        int id PK
        string(255) name
        string(255) line1
        string(255) line2
        string(255) country
        string(50) zipcode
        string(255) city
        array type
    }

    Game{
        int id PK
        string(255) name
        string description
        float price
        int stock
        string(255) slug
        datetime modifiedAt
        datetime createdAt
    }

    Tva{
        int id PK
        string(100) name
        float value
        datetime modifiedAt
        datetime createdAt
    }

    GameImage{
        int it PK
        string(255) name
        string(255) file
        datetime modifiedAt
        datetime createdAt
    }

    GameCategory{
        int id PK
        string(255) name
        string description
        string(255) slug
        datetime modifiedAt
        datetime createdAt
    }

    Review{
        int id PK
        text content
        int review
        datetime modifiedAt
        datetime createdAt
    }

    Order{
        int id PK
        string(255) orderNumber
        float totalPrice
        string(100) status
        datetime createdAt
        datetime shippedAt
    }

    OrderLine{
        int id PK
        int qty
        float price
        float tva
    }

    Payment{
        int id PK
        string(255) type
        float amount
        datetime createdAt
    }



    Review }o--|| Game : has
    Review }o--|| Customer : has

    Game ||--|{ GameImage : has
    Game }o--|| Tva : taxed

    GameCategory }|--o| Game : inside

    User ||--o| Customer : is
    Customer ||--}| CustomerAddress : has

    Order ||--|{ OrderLine : inside
    Customer ||--o{ Order : has
    OrderLine }|--|| Game : inside

    Payment }o--|| Order : isPaid




```

## INSTALLATION

cloner le github

```bash

    # Création de la base de donnée
    php bin/console d:d:c


    # Fixtures
    php bin/console
```
