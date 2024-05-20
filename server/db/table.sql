/*
 * table for products + their possible colors, images, sizes.
 */
CREATE TABLE IF NOT EXISTS
  products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0),
    quantity INT DEFAULT 1,
    availability BOOLEAN NOT NULL,
    item_sold INT NOT NULL DEFAULT 0, -- number of products sold
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

CREATE TABLE IF NOT EXISTS  
  tags (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS tags_mapping (
    product_id INT,
    tag_id INT,
    PRIMARY KEY (product_id, tag_id),
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS
  colors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
  );

CREATE TABLE IF NOT EXISTS
  colors_mapping (
    product_id INT,
    color_id INT,
    PRIMARY KEY (product_id, color_id),
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (color_id) REFERENCES colors (id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE IF NOT EXISTS
  photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    image BLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE IF NOT EXISTS
  sizes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    size_name VARCHAR(20) NOT NULL UNIQUE
  );

CREATE TABLE IF NOT EXISTS
  sizes_mapping (
    product_id INT,
    size_id INT,
    PRIMARY KEY (product_id, size_id),
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (size_id) REFERENCES sizes (id) ON DELETE CASCADE ON UPDATE CASCADE
  );

-- ! END OF GENERIC PRODUCT TABLE
/*
 * subtables for the products table
 */
-- ! SPACESHIP TABLES
/*
TODO: add foreign key to the spaceparts of the ship, for a more detailed description of the ship!!!
 */
CREATE TABLE IF NOT EXISTS
  spaceships (
    product_id INT PRIMARY KEY,
    fuel_type VARCHAR(50) NOT NULL,
    capacity INT,
    speed INT NOT NULL,
    model VARCHAR(255) NOT NULL,
    size VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

-- ! END OF SPACESHIP TABLES
-- ! SPACESUIT TABLES
CREATE TABLE IF NOT EXISTS
  spacesuits (
    product_id INT PRIMARY KEY,
    material VARCHAR(50),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

-- ! END OF SPACESUIT TABLES
/*
? queste si potrebbero anche omettere, da implementare come cosa facoltativa
? potremmo comunque lasciarli anche se a fine progetto non le usiamo che almeno sarebbe
? più completo il database, e potremmo giocarcelo come jolly all'orale per fare bella figura
? diciamo come una delle n funzionalità che il sito dovrebbe avere, ma che per ovvie ragioni non ha.

CREATE TABLE IF NOT EXISTS
  space_parts (
    product_id INT PRIMARY KEY,
    category VARCHAR(50),
    manufacturer VARCHAR(100),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE IF NOT EXISTS
  engines (
    product_id INT PRIMARY KEY,
    thrust_power DECIMAL(10, 2),
    fuel_efficiency DECIMAL(5, 2),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE IF NOT EXISTS
  navigation_systems (
    product_id INT PRIMARY KEY,
    gps_accuracy DECIMAL(5, 2),
    compatibility VARCHAR(100),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE IF NOT EXISTS
  life_support_systems (
    product_id INT PRIMARY KEY,
    oxygen_capacity INT,
    temperature_regulation BOOLEAN,
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE IF NOT EXISTS
  spacecraft_components (
    product_id INT PRIMARY KEY,
    component_type VARCHAR(50),
    manufacturer VARCHAR(100),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );
*/
-- ! END OF PRODUCT SUBTABLES/TABLES
/*
TODO: 
 */
CREATE TABLE IF NOT EXISTS
  users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

CREATE TABLE IF NOT EXISTS
  orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users (id)
  );

CREATE TABLE IF NOT EXISTS
  order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders (id),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE IF NOT EXISTS
  reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (product_id) REFERENCES products (id),
    UNIQUE (user_id, product_id)
  );


-- ! facoltive
CREATE TABLE IF NOT EXISTS
  addresses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    address_line1 VARCHAR(255),
    address_line2 VARCHAR(255),
    city VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users (id)
  );

-- * user can have autologin in more than one device
CREATE TABLE IF NOT EXISTS
  sessions (
    user_id INT,
    session_token VARCHAR(255) PRIMARY KEY NOT NULL,
    expiration_date TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    UNIQUE(user_id, session_token)
  );

CREATE TABLE IF NOT EXISTS
  shopping_cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (product_id) REFERENCES products (id),
    UNIQUE (user_id, product_id) -- ! prevent duplicate entries (just have to change quantity value)
  );

CREATE TABLE IF NOT EXISTS
  wishlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    wishlist_token VARCHAR(255) UNIQUE,
    product_id INT,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (product_id) REFERENCES products (id),
    UNIQUE (user_id, product_id) -- ! prevent duplicate entries (just have to change quantity value)  
  );

CREATE TABLE IF NOT EXISTS
  wishlist_collaborators (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wishlist_id INT,
    collaborator_id INT,
    can_edit BOOLEAN,
    FOREIGN KEY (wishlist_id) REFERENCES wishlist (id),
    FOREIGN KEY (collaborator_id) REFERENCES users (id),
    UNIQUE (collaborator_id, wishlist_id)
  );

/*
 * following tables are probably not implemented. just some thought for the future 
 */
/* -- ! changelog of what user do. it can be usefull to restore some data that users change by mistake
CREATE TABLE IF NOT EXISTS
  audit_trail (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User who made the change
    table_name VARCHAR(50) NOT NULL,
    record_id INT NOT NULL, -- ID of the modified record
    action VARCHAR(10) NOT NULL, -- 'INSERT', 'UPDATE', 'DELETE'
    old_data JSON, -- Old data before the change (for updates and deletes)
    new_data JSON, -- New data after the change (for inserts and updates)
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- ! log of errors that occur in the application
CREATE TABLE IF NOT EXISTS
  error_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User who encountered the error (can be NULL)
    error_message TEXT NOT NULL,
    stack_trace TEXT, -- Detailed stack trace (if available)
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- ! log of security events (error login, new device login, password change, etc.)
CREATE TABLE IF NOT EXISTS
  security_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User involved in the security event (can be NULL for system-level events)
    event_description VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- ! log of performance events (slow queries, etc.) [very very very optional, we're not gonna do this for sure]
CREATE TABLE IF NOT EXISTS
  performance_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User (if applicable)
    action_description VARCHAR(255) NOT NULL,
    execution_time_ms INT, -- Execution time in milliseconds
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- ! log of user sessions (login, logout, etc.)
CREATE TABLE IF NOT EXISTS
  session_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User whose session is involved
    session_action VARCHAR(50) NOT NULL, -- 'Login', 'Logout', etc.
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ); */

CREATE VIEW spacesuits_detail_view AS
SELECT
    p.id AS product_id,
    p.name AS product_name,
    p.description AS product_description,
    p.price AS product_price,
    p.quantity AS product_quantity,
    p.availability AS product_availability,
    p.item_sold AS products_sold,
    pc.name AS color_name,
    pp.image AS product_image,
    ps.size_name AS size_name,
    ss.material AS spacesuit_material,
    AVG(r.rating) AS product_rating,
    p.created_at AS product_created_at,
    p.updated_at AS product_updated_at,
    t.name AS tag_name,
    
FROM
    products p
LEFT JOIN colors_mapping cm ON p.id = cm.product_id
LEFT JOIN colors pc ON cm.color_id = pc.id
LEFT JOIN photos pp ON p.id = pp.product_id
LEFT JOIN sizes_mapping sm ON p.id = sm.product_id
LEFT JOIN sizes ps ON sm.size_id = ps.id
LEFT JOIN reviews r ON p.id = r.product_id
LEFT JOIN tags_mapping tm ON p.id = tm.product_id
LEFT JOIN tags t ON tm.tag_id = t.id 
RIGHT JOIN spacesuits ss ON p.id = ss.product_id
GROUP BY p.id, s.size, pc.name, t.name_name;

CREATE VIEW spaceships_detail_view AS
SELECT
    p.id AS product_id,
    p.name AS product_name,
    p.description AS product_description,
    p.price AS product_price,
    p.quantity AS product_quantity,
    p.availability AS product_availability,
    p.item_sold AS products_sold,
    pc.color_names AS color_names,
    pp.images AS product_images,
    ps.size_names AS size_names,
    s.fuel_type AS spaceship_fuel_type,
    s.capacity AS spaceship_capacity,
    s.speed AS spaceship_speed,
    s.model AS spaceship_model,
    AVG(r.rating) AS product_rating,
    pt.tag_names AS tag_names,
    p.created_at AS product_created_at,
    p.updated_at AS product_updated_at
FROM
    products p
LEFT JOIN (
    SELECT product_id, GROUP_CONCAT(DISTINCT pc.name) AS color_names
    FROM colors_mapping cm
    LEFT JOIN colors pc ON cm.color_id = pc.id
    GROUP BY product_id
) pc ON p.id = pc.product_id
LEFT JOIN (
    SELECT product_id, GROUP_CONCAT(DISTINCT pp.image) AS images
    FROM photos pp
    GROUP BY product_id
) pp ON p.id = pp.product_id
LEFT JOIN (
    SELECT product_id, GROUP_CONCAT(DISTINCT ps.size_name) AS size_names
    FROM sizes_mapping sm
    LEFT JOIN sizes ps ON sm.size_id = ps.id
    GROUP BY product_id
) ps ON p.id = ps.product_id
LEFT JOIN reviews r ON p.id = r.product_id
LEFT JOIN (
    SELECT product_id, GROUP_CONCAT(DISTINCT t.name) AS tag_names
    FROM tags_mapping tm
    LEFT JOIN tags t ON tm.tag_id = t.id
    GROUP BY product_id
) pt ON p.id = pt.product_id
RIGHT JOIN spaceships s ON p.id = s.product_id
GROUP BY p.id, p.name, p.description, p.price, p.quantity, p.availability, p.item_sold, s.fuel_type, s.capacity, s.speed, s.model, p.created_at, p.updated_at, pp.images;




/*
  * INSERTO FOR THE TABLES
*/

INSERT INTO
  colors (name)
VALUES
  ('Red'),
  ('Blue'),
  ('Green'),
  ('Yellow'),
  ('Black'),
  ('White');

INSERT INTO
  sizes (size_name)
VALUES
  ('XXS'),
  ('XS'),
  ('S'),
  ('M'),
  ('L'),
  ('XL'),
  ('XXL'),
  ('XXXL');

INSERT INTO tags (name) VALUES ('Spaceship');
INSERT INTO tags (name) VALUES ('Spacecraft');
INSERT INTO tags (name) VALUES ('Interstellar Travel');
INSERT INTO tags (name) VALUES ('Space Exploration');
INSERT INTO tags (name) VALUES ('Alien Encounters');
INSERT INTO tags (name) VALUES ('Galactic Adventure');
INSERT INTO tags (name) VALUES ('Starship');
INSERT INTO tags (name) VALUES ('Futuristic Technology');
INSERT INTO tags (name) VALUES ('Extraterrestrial Life');
INSERT INTO tags (name) VALUES ('Deep Space');
INSERT INTO tags (name) VALUES ('Space Mission');
INSERT INTO tags (name) VALUES ('Astroengineering');
INSERT INTO tags (name) VALUES ('Intergalactic Travel');
INSERT INTO tags (name) VALUES ('Outer Space');
INSERT INTO tags (name) VALUES ('Space Adventure');

-- ! SPACESUITS INSERTS

-- Product B
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Spacesuit Product B', 'Description for Spacesuit Product B', 59.99, 15, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 2);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 1);
INSERT INTO spacesuits (product_id, material) VALUES (@new_product_id, 'Advanced Fabric');

-- Continue the pattern for Spacesuit Products C to J

-- Product C
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Spacesuit Product C', 'Description for Spacesuit Product C', 69.99, 20, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 3);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 3);
INSERT INTO spacesuits (product_id, material) VALUES (@new_product_id, 'Carbon Fiber');

-- ! SPACESHIP INSERTS

-- Product B
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product B', 'Description for Product B', 24.99, 10, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 3);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 2);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 1);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Advanced Fuel', 120, 2500, 'Model B', 'Medium');

-- Product C

INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product C', 'Description for Product C', 49.99, 20, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 2);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 5);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 7);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 12);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Quantum Fuel', 300, 4000, 'Model X', 'Large');

-- Product D

INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product D', 'Description for Product D', 74.99, 15, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 4);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 7);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 2);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 9);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Plasma Drive', 200, 3500, 'Model Y', 'Extra Large');

-- Product E
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product E', 'Description for Product E', 99.99, 30, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 6);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 3);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 5);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Hyperdrive', 400, 5000, 'Model Z', 'Extra Large');

-- Product F
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product F', 'Description for Product F', 149.99, 25, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 1);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 8);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 8);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Warp Drive', 500, 6000, 'Model Alpha', 'Extra Extra Large');

-- Product G
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product G', 'Description for Product G', 64.99, 18, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 3);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 6);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 3);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 11);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Ion Propulsion', 250, 4500, 'Model Delta', 'Large');

-- Product H
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product H', 'Description for Product H', 39.99, 22, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 5);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 2);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 4);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 10);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Antimatter Drive', 300, 5500, 'Model Gamma', 'Medium');

-- Product I
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product I', 'Description for Product I', 129.99, 12, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 1);
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 2);
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 3);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 4);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 7);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 1);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 2);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 3);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 4);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Plasma Drive', 350, 4500, 'Model Omega', 'Extra Large');

-- Product J
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product J', 'Description for Product J', 89.99, 15, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 2);
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 4);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 3);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 6);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 5);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 6);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 7);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 8);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Quantum Fuel', 280, 3800, 'Model Beta', 'Large');

-- Product K
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product K', 'Description for Product K', 199.99, 8, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 3);
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 5);
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 6);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 2);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 5);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 9);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 10);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 11);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 12);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Warp Drive', 600, 7000, 'Model Sigma', 'Extra Extra Large');

-- Product L
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product L', 'Description for Product L', 149.99, 20, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 1);
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 4);
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 6);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 4);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 7);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 1);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 5);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 9);
INSERT INTO tags_mapping (product_id, tag_id) VALUES (@new_product_id, 12);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Hyperdrive', 450, 5500, 'Model Epsilon', 'Extra Large');

-- ! SOME USEFULL TRIGGERS
CREATE TRIGGER update_availability BEFORE
UPDATE ON products FOR EACH ROW
SET
  NEW.availability = IF (NEW.quantity <= 0, FALSE, TRUE);

-- ! END OF TRIGGERS