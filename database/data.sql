-- Active: 1765134969045@@localhost@3306@mabagnole
CREATE DATABASE MABAGNOLE;

use mabagnole;

create Table Users (
    Users_id INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(100) NOT NULL,
    userEmail VARCHAR(100) NOT NULL UNIQUE,
    userRole VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    userStatus VARCHAR(20),
    userCreated DATETIME DEFAULT NOW()
);

CREATE Table Vehicle (
    Vehicle_id INT AUTO_INCREMENT PRIMARY KEY,
    image text NOT NULL,
    vehicleModel VARCHAR(100) NOT NULL,
    vehicleDescription TEXT NOT NULL,
    vehiclePricePerDay DECIMAL(6, 2) NOT NULL,
    vehicleAvailability BOOLEAN,
    vehicleIdCategory INT,
    FOREIGN KEY (vehicleIdCategory) REFERENCES Category (Category_id)
);

create table Category (
    Category_id INT AUTO_INCREMENT PRIMARY KEY,
    categoryName VARCHAR(100) NOT NULL,
    categoryDescription text NOT NULL
);

create table Reservation (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    reservationStartDate DATE NOT NULL,
    reservationEndDate DATE NOT NULL,
    reservationPickUpLocation VARCHAR(255) NOT NULL,
    reservationStatus VARCHAR(50) NOT NULL,
    reservationTotalAmount DECIMAL NOT NULL,
    reservationIdUser INT,
    reservationIdVehicle INT,
    FOREIGN KEY (reservationIdUser) REFERENCES Users (Users_id),
    FOREIGN KEY (reservationIdVehicle) REFERENCES Vehicle (Vehicle_id)
);

create TABLE Review (
    Review_id INT AUTO_INCREMENT PRIMARY KEY,
    reviewRate INT,
    reviewComment VARCHAR(255) NOT NULL,
    reviewDeleteTime DATETIME DEFAULT NULL,
    reviewIdUser INT,
    reviewIdVehicle INT,
    FOREIGN KEY (reviewIdUser) REFERENCES Users (Users_id),
    FOREIGN KEY (reviewIdVehicle) REFERENCES Vehicle (Vehicle_id)
);

CREATE TABLE Themes (
    Theme_id INT AUTO_INCREMENT PRIMARY KEY,
    themeTitle VARCHAR(255) NOT NULL,
    themeDescription TEXT NOT NULL
)

CREATE TABLE Articles (
    Article_id INT AUTO_INCREMENT PRIMARY KEY,
    articleThemeId INT,
    articleUserId INT,
    articleTitle VARCHAR(255),
    articleContent TEXT NOT NULL,
    media_url VARCHAR(255) NULL,
    articleStatus VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    updated_at DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    FOREIGN KEY (articleThemeId) REFERENCES Themes (Theme_id),
    FOREIGN KEY (articleUserId) REFERENCES Users (Users_id)
)

CREATE TABLE Tags (
    Tag_id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(80) NOT NULL UNIQUE
)

CREATE TABLE Article_Tags (
    Article_Tag_Id INT AUTO_INCREMENT PRIMARY KEY,
    articleTagId INT NOT NULL,
    tagArticleId INT NOT NULL,
    FOREIGN KEY (articleTagId) REFERENCES Articles (Article_id),
    FOREIGN KEY (tagArticleId) REFERENCES Tags (Tag_id)
)

CREATE TABLE Comments (
    Comment_id INT AUTO_INCREMENT PRIMARY KEY,
    commentArticleId INT NOT NULL,
    commentUserId INT NOT NULL,
    commentContent TEXT NOT NULL,
    commentCreatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    commentDeletedAt DATETIME DEFAULT NULL,
    FOREIGN KEY (commentArticleId) REFERENCES Articles (Article_id),
    FOREIGN KEY (commentUserId) REFERENCES Users (Users_id)
);

CREATE TABLE Favorite_Articles (
    Favorite_id INT AUTO_INCREMENT PRIMARY KEY,
    favoriteArticleUserId INT NOT NULL,
    favoriteArticleId INT NOT NULL,
    favoriteArticleCreatedAt DATETIME NOT NULL DEFAULT NOW(),
    FOREIGN KEY (favoriteArticleUserId) REFERENCES Users (Users_id),
    FOREIGN KEY (favoriteArticleId) REFERENCES Articles (Article_id)
);

CREATE VIEW ListeVehicules AS
SELECT *
FROM
    Vehicle v
    LEFT JOIN Category ca ON v.vehicleIdCategory = ca.Category_id
    LEFT JOIN Review r ON v.Vehicle_id = r.reviewIdVehicle;

SELECT * FROM ListeVehicules;

CREATE PROCEDURE AjouterReservation(
    IN p_start DATE ,
    IN p_end DATE ,
    IN p_PickUpLocation VARCHAR(255) ,
    IN p_Status VARCHAR(50) ,
    IN p_TotalAmount DECIMAL(10,2) ,
    IN p_user_id INT ,
    IN p_vehicle_id INT 
)
BEGIN
    INSERT INTO Reservation 
            (reservationStartDate, reservationEndDate, reservationPickUpLocation,
             reservationStatus, reservationTotalAmount, reservationIdUser, reservationIdVehicle)
    VALUES (p_start, p_end, p_PickUpLocation, p_Status, p_TotalAmount, p_user_id, p_vehicle_id);
END;

call AjouterReservation (
    '2026-01-10',
    '2026-01-15',
    'agadir',
    'done',
    130.00,
    1,
    1
);

INSERT INTO
    Category (
        categoryName,
        categoryDescription
    )
VALUES (
        'Sedan Cars',
        'Comfortable cars suitable for daily use and families'
    ),
    (
        'SUV Cars',
        'Sport Utility Vehicles for city and off-road driving'
    ),
    (
        'Hatchback Cars',
        'Compact cars ideal for urban environments'
    ),
    (
        'Sports Cars',
        'High-performance cars designed for speed and style'
    ),
    (
        'Luxury Cars',
        'Premium cars with high-end comfort and features'
    ),
    (
        'Electric Cars',
        'Cars powered fully by electric energy'
    ),
    (
        'Hybrid Cars',
        'Cars using both fuel and electric power'
    ),
    (
        'Convertible Cars',
        'Cars with removable or folding roofs'
    ),
    (
        'Coupe Cars',
        'Two-door cars with a sporty design'
    ),
    (
        'Pickup Cars',
        'Cars designed for transport and utility purposes'
    );

INSERT INTO
    Vehicle (
        image,
        vehicleModel,
        vehicleDescription,
        vehiclePricePerDay,
        vehicleAvailability,
        vehicleIdCategory
    )
VALUES (
        'https://mkt-vehicleimages-prd.autotradercdn.ca/photos/chrome/Expanded/White/2020TOC020016/2020TOC02001601.jpg',
        'Toyota Camry',
        'Reliable and comfortable sedan',
        45.00,
        1,
        1
    ),
    (
        'https://di-uploads-pod1.dealerinspire.com/wallawallavalleyhonda/uploads/2016/10/2017-Honda-Accord-Features.jpg',
        'Honda Accord',
        'Spacious sedan with smooth driving',
        48.00,
        1,
        1
    ),
    (
        'suv_toyota_rav4.jpg',
        'Toyota RAV4',
        'Compact SUV suitable for city and travel',
        65.00,
        1,
        2
    ),
    (
        'suv_bmw_x5.jpg',
        'BMW X5',
        'Luxury SUV with powerful performance',
        120.00,
        1,
        2
    ),
    (
        'hatchback_vw_golf.jpg',
        'Volkswagen Golf',
        'Compact hatchback for urban driving',
        40.00,
        1,
        3
    ),
    (
        'hatchback_ford_fiesta.jpg',
        'Ford Fiesta',
        'Economic and easy-to-drive hatchback',
        35.00,
        1,
        3
    ),
    (
        'sports_porsche_911.jpg',
        'Porsche 911',
        'High-performance sports car',
        250.00,
        1,
        4
    ),
    (
        'sports_ford_mustang.jpg',
        'Ford Mustang',
        'Iconic American muscle car',
        180.00,
        0,
        4
    ),
    (
        'luxury_mercedes_sclass.jpg',
        'Mercedes S-Class',
        'Top luxury sedan with premium comfort',
        220.00,
        1,
        5
    ),
    (
        'luxury_bmw_7series.jpg',
        'BMW 7 Series',
        'Executive luxury car',
        200.00,
        1,
        5
    ),
    (
        'electric_tesla_model3.jpg',
        'Tesla Model 3',
        'Fully electric car with autopilot features',
        90.00,
        1,
        6
    ),
    (
        'electric_nissan_leaf.jpg',
        'Nissan Leaf',
        'Affordable electric vehicle',
        70.00,
        1,
        6
    ),
    (
        'hybrid_toyota_prius.jpg',
        'Toyota Prius',
        'Fuel-efficient hybrid car',
        60.00,
        1,
        7
    ),
    (
        'hybrid_honda_insight.jpg',
        'Honda Insight',
        'Modern hybrid sedan',
        62.00,
        1,
        7
    ),
    (
        'convertible_mini.jpg',
        'Mini Cooper Convertible',
        'Stylish convertible for city rides',
        85.00,
        1,
        8
    ),
    (
        'convertible_bmw_z4.jpg',
        'BMW Z4',
        'Sporty luxury convertible',
        150.00,
        0,
        8
    ),
    (
        'coupe_audi_a5.jpg',
        'Audi A5 Coupe',
        'Elegant coupe with sporty look',
        110.00,
        1,
        9
    ),
    (
        'coupe_mercedes_c.jpg',
        'Mercedes C Coupe',
        'Premium compact coupe',
        115.00,
        1,
        9
    ),
    (
        'pickup_ford_ranger.jpg',
        'Ford Ranger',
        'Strong pickup for transport and work',
        75.00,
        1,
        10
    ),
    (
        'pickup_toyota_hilux.jpg',
        'Toyota Hilux',
        'Reliable pickup for heavy usage',
        80.00,
        1,
        10
    );

INSERT INTO
    Users (
        userName,
        userEmail,
        userRole,
        password_hash,
        userStatus
    )
VALUES (
        'John Doe',
        'john.doe@gmail.com',
        'client',
        '$2y$10$N9qo8uLOickgx2ZMRZo5i.UvL9p5VxC1zQG6H1m5JpLz3rO6R8F1K',
        'active'
    ),
    (
        'Jane Smith',
        'jane.smith@gmail.com',
        'client',
        '$2y$10$N9qo8uLOickgx2ZMRZo5i.UvL9p5VxC1zQG6H1m5JpLz3rO6R8F1K',
        'active'
    ),
    (
        'Mark Lee',
        'mark.lee@gmail.com',
        'client',
        '$2y$10$N9qo8uLOickgx2ZMRZo5i.UvL9p5VxC1zQG6H1m5JpLz3rO6R8F1K',
        'inactive'
    );

--password : Test@123

INSERT INTO
    Reservation (
        reservationStartDate,
        reservationEndDate,
        reservationPickUpLocation,
        reservationStatus,
        reservationTotalAmount,
        reservationIdUser,
        reservationIdVehicle
    )
VALUES (
        '2026-01-10',
        '2026-01-15',
        'Casablanca',
        'pending',
        3500.00,
        1,
        1
    ),
    (
        '2026-02-01',
        '2026-02-05',
        'Marrakech',
        'confirmed',
        4200.00,
        2,
        2
    ),
    (
        '2026-03-05',
        '2026-03-10',
        'Rabat',
        'cancelled',
        2800.00,
        3,
        3
    );

INSERT INTO
    Review (
        reviewRate,
        reviewComment,
        reviewDeleteTime,
        reviewIdUser,
        reviewIdVehicle
    )
VALUES (
        5,
        'Excellent car, very clean and comfortable.',
        NULL,
        1,
        1
    ),
    (
        4,
        'Smooth driving experience, will rent again.',
        NULL,
        2,
        1
    ),
    (
        3,
        'Good vehicle but fuel consumption was high.',
        NULL,
        3,
        2
    ),
    (
        5,
        'Luxury and comfort at its best!',
        NULL,
        4,
        3
    ),
    (
        4,
        'Perfect for family trips.',
        NULL,
        5,
        2
    ),
    (
        2,
        'Car was okay but delivery was late.',
        NULL,
        1,
        4
    ),
    (
        5,
        'Amazing performance and handling.',
        NULL,
        2,
        3
    ),
    (
        3,
        'Decent experience, nothing special.',
        NULL,
        3,
        4
    ),
    (
        1,
        'Very bad experience, car was dirty.',
        '2025-12-20 14:30:00',
        4,
        1
    ),
    (
        2,
        'Vehicle had mechanical issues.',
        '2025-12-22 09:15:00',
        5,
        2
    );

INSERT INTO
    Themes (themeTitle, themeDescription)
VALUES (
        'Car Rental Tips',
        'Useful tips for renting vehicles efficiently and cost-effectively.'
    ),
    (
        'Automobile Reviews',
        'Reviews and feedback on the latest car models available in the market.'
    ),
    (
        'Maintenance & Care',
        'Advice on maintaining and caring for vehicles to extend their lifespan.'
    ),
    (
        'Travel Adventures',
        'Stories from car trips and travel adventures.'
    ),
    (
        'Electric Vehicles',
        'Information and updates on electric vehicles and their impact on transportation.'
    );

INSERT INTO
    Users (
        userName,
        userEmail,
        userRole,
        password_hash,
        userStatus
    )
VALUES (
        'John Doe',
        'johndoe@email.com',
        'CLIENT',
        'hashed_password_1',
        'active'
    ),
    (
        'Jane Smith',
        'janesmith@email.com',
        'CLIENT',
        'hashed_password_2',
        'active'
    ),
    (
        'Admin User',
        'admin@email.com',
        'ADMIN',
        'hashed_password_3',
        'active'
    );

INSERT INTO
    Articles (
        articleThemeId,
        articleUserId,
        articleTitle,
        articleContent,
        media_url,
        articleStatus
    )
VALUES (
        1,
        1,
        '5 Tips for Renting a Car',
        'Learn 5 useful tips that will make your car rental experience smoother and more affordable.',
        'car_rentals.jpg',
        'approved'
    ),
    (
        2,
        2,
        'The Latest Review of Tesla Model S',
        'A detailed review of the Tesla Model S, its features, performance, and reliability.',
        'tesla_model_s.jpg',
        'approved'
    ),
    (
        3,
        3,
        'How to Maintain Your Car’s Engine',
        'A step-by-step guide on how to maintain your car’s engine and ensure its longevity.',
        NULL,
        'pending'
    ),
    (
        4,
        2,
        'The Best Road Trips for 2026',
        'Planning your next road trip? Here are the best road trips to take in 2026.',
        NULL,
        'approved'
    ),
    (
        5,
        1,
        'The Future of Electric Vehicles',
        'A look at the impact of electric vehicles on the transportation industry and what the future holds.',
        NULL,
        'pending'
    );

INSERT INTO
    Tags (label)
VALUES ('tips'),
    ('review'),
    ('maintenance'),
    ('travel'),
    ('electric');

INSERT INTO
    Article_Tags (articleTagId, tagArticleId)
VALUES (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5);

INSERT INTO
    Comments (
        commentArticleId,
        commentUserId,
        commentContent
    )
VALUES (
        1,
        2,
        'Great tips! This will help me save a lot on rentals next time.'
    ),
    (
        2,
        1,
        'The Tesla Model S is an incredible car! Thanks for the thorough review.'
    ),
    (
        3,
        3,
        'I will definitely follow these engine maintenance tips for my car.'
    ),
    (
        4,
        2,
        'I am planning a road trip next year and will check out your recommendations.'
    ),
    (
        5,
        1,
        'I am looking forward to the future of electric vehicles, especially for city travel.'
    );

INSERT INTO
    Favorite_Articles (
        favoriteArticleUserId,
        favoriteArticleId
    )
VALUES (1, 2),
    (2, 4),
    (3, 5);

SELECT * FROM Articles;

SELECT * FROM Articles a
        LEFT JOIN Themes t ON a.articleThemeId = t.Theme_id
        LEFT JOIN Users u ON a.articleUserId = u.Users_id
        LEFT JOIN Article_Tags au on au.articleTagId = a.Article_id
        LEFT JOIN Tags tg on tg.Tag_id = au.tagArticleId
        WHERE a.articleThemeId = 2;


SELECT *
        FROM Comments c
        LEFT JOIN Users u ON c.commentUserId = u.Users_id
        LEFT JOIN Articles a ON c.commentArticleId = a.Article_id
        WHERE c.commentArticleId = 1
          AND c.commentDeletedAt IS NULL
        ORDER BY c.commentCreatedAt DESC


        UPDATE Comments
        SET commentDeletedAt = NOW()
        WHERE Comment_id = 17;


        SELECT * FROM Articles a
        LEFT JOIN Themes t ON a.articleThemeId = t.Theme_id
        LEFT JOIN Users u ON a.articleUserId = u.Users_id
        LEFT JOIN Article_Tags au ON au.articleTagId = a.Article_id
        LEFT JOIN Tags tg ON tg.Tag_id = au.tagArticleId
        WHERE a.articleThemeId = 1 AND articleStatus = 'approved'
            ORDER BY created_at DESC
            LIMIT 2 OFFSET 3