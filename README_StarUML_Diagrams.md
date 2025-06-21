# StarUML Diagrams for E-commerce Platform Project

This directory contains comprehensive StarUML diagram files for the e-commerce platform project with Dolibarr integration. All diagrams are provided in StarUML's native `.mdj` format.

## Files Overview

### 1. `staruml_diagrams.mdj`
**Main comprehensive project file** containing:
- Global system overview diagrams
- All sprint-specific diagrams in one file
- Basic structure for all diagram types

### 2. `authentication_diagrams.mdj`
**Sprint 1: Authentication System**
- **Class Diagrams:**
  - `AuthController`: Handles authentication logic
  - `UserModel`: User data management
  - `SessionManager`: Session handling
  - `PasswordManager`: Password security
  - `EmailService`: Email notifications

- **Use Case Diagrams:**
  - User Registration
  - User Login
  - Password Reset
  - Profile Update
  - Logout

### 3. `product_catalog_diagrams.mdj`
**Sprint 2: Product Catalog & Cart**
- **Class Diagrams:**
  - `ProductController`: Product management
  - `ProductModel`: Product data structure
  - `CategoryModel`: Product categorization
  - `CartController`: Shopping cart logic
  - `CartModel`: Cart data management

- **Use Case Diagrams:**
  - Browse Products
  - Search Products
  - Filter Products
  - Add to Cart
  - Manage Cart
  - View Product Details

### 4. `orders_support_diagrams.mdj`
**Sprint 3: Orders & Support System**
- **Class Diagrams:**
  - `OrderController`: Order processing
  - `OrderModel`: Order data structure
  - `PaymentService`: Payment processing
  - `TicketController`: Support ticket management
  - `TicketModel`: Support ticket data

- **Use Case Diagrams:**
  - Create Order
  - Process Payment
  - Track Order
  - View Order History
  - Create Support Ticket
  - Manage Tickets
  - Respond to Tickets

### 5. `sequence_diagrams.mdj`
**All Sequence Diagrams**
- **Authentication Sequences:**
  - User Registration Sequence
  - User Login Sequence

- **Product & Cart Sequences:**
  - Product Display Sequence
  - Add to Cart Sequence

- **Order & Support Sequences:**
  - Order Creation Sequence
  - Support Ticket Creation Sequence

### 6. `global_diagrams.mdj`
**System Architecture Diagrams**
- **Global Class Diagram:**
  - `BaseController`: Common controller functionality
  - `BaseModel`: Common model functionality
  - `DolibarrAPI`: Dolibarr integration
  - `DatabaseManager`: Database operations
  - `SecurityManager`: Security features
  - `ConfigManager`: Configuration management

- **Global Use Case Diagram:**
  - System-wide use cases for all user types
  - Actor relationships (Visitor, Customer, Administrator)

- **Deployment Diagram:**
  - Web Server
  - Database Server
  - Dolibarr Server
  - Client Browser

## How to Use

### Opening Files in StarUML
1. Install StarUML from [staruml.io](http://staruml.io/)
2. Open StarUML application
3. Go to `File > Open` and select any `.mdj` file
4. Navigate through the model tree on the left panel
5. Double-click on any diagram to view it

### Diagram Navigation
- **Model Tree:** Left panel shows the hierarchical structure
- **Diagram Canvas:** Center area displays the selected diagram
- **Properties Panel:** Right panel shows element properties
- **Toolbox:** Contains tools for editing diagrams

### Editing Diagrams
1. Select elements to modify properties
2. Use toolbox to add new elements
3. Drag and drop to reposition elements
4. Right-click for context menus
5. Use alignment tools for better layout

## Diagram Details

### Class Diagrams Include:
- **Attributes:** Private (-), Protected (#), Public (+)
- **Methods:** With parameters and return types
- **Relationships:** Inheritance, associations, dependencies
- **Stereotypes:** Controller, Model, Service patterns

### Use Case Diagrams Include:
- **Actors:** Visitor, Customer, Administrator, Support Agent
- **Use Cases:** Functional requirements
- **Relationships:** Include, extend, associations
- **System Boundaries:** Clear scope definition

### Sequence Diagrams Include:
- **Lifelines:** System components and actors
- **Messages:** Method calls and responses
- **Activation Boxes:** Processing periods
- **Return Messages:** Response flows

## Technical Implementation Notes

### Dolibarr Integration
All diagrams include integration points with:
- **Modules:** Users, Products, Orders, Tickets
- **APIs:** REST endpoints for data exchange
- **Database Tables:** Direct table relationships
- **Charts:** Dolibarr reporting integration

### Security Considerations
- Authentication flows with session management
- Password hashing and validation
- CSRF protection mechanisms
- Input validation and sanitization

### Database Design
- Normalized table structures
- Foreign key relationships
- Index optimization considerations
- Data integrity constraints

## Customization

To customize these diagrams:
1. Open the relevant `.mdj` file
2. Modify existing elements or add new ones
3. Update relationships as needed
4. Save changes to preserve modifications
5. Export to various formats (PNG, PDF, SVG) if needed

## Export Options

StarUML supports exporting to:
- **Images:** PNG, JPEG, SVG
- **Documents:** PDF
- **Code:** Various programming languages
- **Other Formats:** XMI, HTML

## Support

For questions about these diagrams:
1. Refer to the main project documentation
2. Check StarUML documentation for tool usage
3. Review the source code for implementation details

---

**Note:** These diagrams represent the design phase of the project. Actual implementation may vary based on development decisions and requirements changes.