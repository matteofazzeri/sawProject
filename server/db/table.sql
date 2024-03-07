-- ! SOME USEFULL TRIGGERS
CREATE TRIGGER update_availability BEFORE
UPDATE ON products FOR EACH ROW
SET
  NEW.availability = IF (NEW.quantity <= 0, FALSE, TRUE);

-- ! END OF TRIGGERS
/*
 * table for products + their possible colors, images, sizes.
 */
CREATE TABLE
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

CREATE TABLE
  product_colors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
  );

CREATE TABLE
  colors_mapping (
    product_id INT,
    color_id INT,
    PRIMARY KEY (product_id, color_id),
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (color_id) REFERENCES product_colors (id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  product_photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    image BLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  product_sizes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    size_name VARCHAR(20) NOT NULL UNIQUE
  );


CREATE TABLE
  sizes_mapping (
    product_id INT,
    size_id INT,
    PRIMARY KEY (product_id, size_id),
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (size_id) REFERENCES product_sizes (id) ON DELETE CASCADE ON UPDATE CASCADE
  );

-- ! END OF GENERIC PRODUCT TABLE
/*
 * subtables for the products table
 */
-- ! SPACESHIP TABLES
/*
TODO: add foreign key to the spaceparts of the ship, for a more detailed description of the ship!!!
 */
CREATE TABLE
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
CREATE TABLE
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

CREATE TABLE
  space_parts (
    product_id INT PRIMARY KEY,
    category VARCHAR(50),
    manufacturer VARCHAR(100),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE
  engines (
    product_id INT PRIMARY KEY,
    thrust_power DECIMAL(10, 2),
    fuel_efficiency DECIMAL(5, 2),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE
  navigation_systems (
    product_id INT PRIMARY KEY,
    gps_accuracy DECIMAL(5, 2),
    compatibility VARCHAR(100),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE
  life_support_systems (
    product_id INT PRIMARY KEY,
    oxygen_capacity INT,
    temperature_regulation BOOLEAN,
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE
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
CREATE TABLE
  users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

CREATE TABLE
  orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users (id)
  );

CREATE TABLE
  order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders (id),
    FOREIGN KEY (product_id) REFERENCES products (id)
  );

CREATE TABLE
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
CREATE TABLE
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
CREATE TABLE
  sessions (
    user_id INT,
    session_token VARCHAR(255) PRIMARY KEY NOT NULL,
    expiration_date TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    UNIQUE(user_id, session_token)
  );

CREATE TABLE
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

CREATE TABLE
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

CREATE TABLE
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
-- ! changelog of what user do. it can be usefull to restore some data that users change by mistake
CREATE TABLE
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
CREATE TABLE
  error_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User who encountered the error (can be NULL)
    error_message TEXT NOT NULL,
    stack_trace TEXT, -- Detailed stack trace (if available)
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- ! log of security events (error login, new device login, password change, etc.)
CREATE TABLE
  security_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User involved in the security event (can be NULL for system-level events)
    event_description VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- ! log of performance events (slow queries, etc.) [very very very optional, we're not gonna do this for sure]
CREATE TABLE
  performance_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User (if applicable)
    action_description VARCHAR(255) NOT NULL,
    execution_time_ms INT, -- Execution time in milliseconds
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

-- ! log of user sessions (login, logout, etc.)
CREATE TABLE
  session_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT, -- User whose session is involved
    session_action VARCHAR(50) NOT NULL, -- 'Login', 'Logout', etc.
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );


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
    p.updated_at AS product_updated_at
FROM
    products p
LEFT JOIN colors_mapping cm ON p.id = cm.product_id
LEFT JOIN product_colors pc ON cm.color_id = pc.id
LEFT JOIN product_photos pp ON p.id = pp.product_id
LEFT JOIN sizes_mapping sm ON p.id = sm.product_id
LEFT JOIN product_sizes ps ON sm.size_id = ps.id
LEFT JOIN reviews r ON p.id = r.product_id
RIGHT JOIN spacesuits ss ON p.id = ss.product_id
GROUP BY p.id;

CREATE VIEW spaceships_detail_view AS
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
    s.fuel_type AS spaceship_fuel_type,
    s.capacity AS spaceship_capacity,
    s.speed AS spaceship_speed,
    s.model AS spaceship_model,
    s.size AS spaceship_size,
    AVG(r.rating) AS product_rating,
    p.created_at AS product_created_at,
    p.updated_at AS product_updated_at
FROM
    products p
LEFT JOIN colors_mapping cm ON p.id = cm.product_id
LEFT JOIN product_colors pc ON cm.color_id = pc.id
LEFT JOIN product_photos pp ON p.id = pp.product_id
LEFT JOIN sizes_mapping sm ON p.id = sm.product_id
LEFT JOIN product_sizes ps ON sm.size_id = ps.id
LEFT JOIN reviews r ON p.id = r.product_id
RIGHT JOIN spaceships s ON p.id = s.product_id
GROUP BY p.id;



/*
  * INSERTO FOR THE TABLES
*/

INSERT INTO
  product_colors (name)
VALUES
  ('Red'),
  ('Blue'),
  ('Green'),
  ('Yellow'),
  ('Black'),
  ('White');

INSERT INTO
  product_sizes (size_name)
VALUES
  ('XXS'),
  ('XS'),
  ('S'),
  ('M'),
  ('L'),
  ('XL'),
  ('XXL'),
  ('XXXL');


-- ! SPACESUITS INSERTS


  -- Insert into products table
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Test Spacesuit Product', 'Description for the test spacesuit product', 39.99, 15, true, 0);

-- Retrieve the ID of the newly inserted product
SET @new_product_id = LAST_INSERT_ID();

-- Insert into colors_mapping table
INSERT INTO colors_mapping (product_id, color_id)
VALUES (@new_product_id, 3); -- Assuming color_id 3 exists in product_colors table

-- Insert into sizes_mapping table
INSERT INTO sizes_mapping (product_id, size_id)
VALUES (@new_product_id, 3); -- Assuming size_id 3 exists in product_sizes table

-- Insert into spacesuits table
INSERT INTO spacesuits (product_id, material)
VALUES (@new_product_id, 'Advanced Polymer');

-- Insert into products table
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Spacesuit Product A', 'Description for Spacesuit Product A', 49.99, 10, true, 0);

-- Retrieve the ID of the newly inserted product
SET @new_product_id = LAST_INSERT_ID();

-- Insert into colors_mapping table
INSERT INTO colors_mapping (product_id, color_id)
VALUES (@new_product_id, 1); -- Assuming color_id 1 exists in product_colors table

-- Insert into sizes_mapping table
INSERT INTO sizes_mapping (product_id, size_id)
VALUES (@new_product_id, 2); -- Assuming size_id 2 exists in product_sizes table

-- Insert into spacesuits table
INSERT INTO spacesuits (product_id, material)
VALUES (@new_product_id, 'Nano Fiber');

-- Repeat the above structure for the next 8 spacesuit products (Product B to Product J)

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

-- ... Repeat for Spacesuit Products D to J



-- ! SPACESHIP INSERTS



-- Insert into products table
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Test Spaceship Product', 'Description for the test product', 29.99, 20, true, 0);

-- Retrieve the ID of the newly inserted product
SET @new_product_id = LAST_INSERT_ID();

-- Insert into colors_mapping table
INSERT INTO colors_mapping (product_id, color_id)
VALUES (@new_product_id, 2); -- Assuming color_id 2 exists in product_colors table

-- Insert into sizes_mapping table
INSERT INTO sizes_mapping (product_id, size_id)
VALUES (@new_product_id, 2); -- Assuming size_id 2 exists in product_sizes table

-- Insert into spaceships table
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Hyper Fuel', 150, 3000, 'Test Model', 'Medium');

-- Insert into products table
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product A', 'Description for Product A', 19.99, 15, true, 0);

-- Retrieve the ID of the newly inserted product
SET @new_product_id = LAST_INSERT_ID();

-- Insert into colors_mapping table
INSERT INTO colors_mapping (product_id, color_id)
VALUES (@new_product_id, 1); -- Assuming color_id 1 exists in product_colors table

-- Insert into sizes_mapping table
INSERT INTO sizes_mapping (product_id, size_id)
VALUES (@new_product_id, 1); -- Assuming size_id 1 exists in product_sizes table

-- Insert into spaceships table
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Standard Fuel', 100, 2000, 'Model A', 'Small');


-- Repeat the above structure for the next 8 products (Product B to Product J)

-- Product B
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product B', 'Description for Product B', 24.99, 10, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 3);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 2);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Advanced Fuel', 120, 2500, 'Model B', 'Medium');

-- Continue the pattern for Products C to J

-- Product C
INSERT INTO products (name, description, price, quantity, availability, item_sold)
VALUES ('Product C', 'Description for Product C', 29.99, 20, true, 0);
SET @new_product_id = LAST_INSERT_ID();
INSERT INTO colors_mapping (product_id, color_id) VALUES (@new_product_id, 2);
INSERT INTO sizes_mapping (product_id, size_id) VALUES (@new_product_id, 1);
INSERT INTO spaceships (product_id, fuel_type, capacity, speed, model, size)
VALUES (@new_product_id, 'Hyper Fuel', 150, 3000, 'Model C', 'Large');
