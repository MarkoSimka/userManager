# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/MarkoSimka/userManager.git

Switch to the repo folder

    cd userManager

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

Change caching folders permissions:

    sudo chmod -R 777 storage && chmod -R 777 bootstrap/cache

## Configure the .env file

Open .env and set up the database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```
Ensure **MySQL** is running in **XAMPP** before proceeding.

You can now access the server at http://127.0.0.1:8000

##    ER Diagram

![Untitled Diagram drawio](https://github.com/user-attachments/assets/ec1c8666-b530-4309-94fb-e5c639ffe628)

###    Description
The system manages conversations between brokers and vendors, with users employed by companies. Conversations can be started by primary users and must involve at least one broker and one vendor. Messages can include text and files. Read receipts track unread messages for each user. The ER diagram captures these entities and their relationships.

### **Entities & Relationships**
The following entities and relationships define the system:

### **1. COMPANY**
- **Key Attributes**: `id`, `name`, `type`
- **Description**: Represents a broker or vendor company.
- **Relationships**:
  - **One-to-Many**: `COMPANY` → `USER` (A company employs multiple users)
  - **One-to-Many**: `COMPANY` → `CONVERSATION` (A company participates in conversations)

---

### **2. USER**
- **Key Attributes**: `id`, `name`, `companyId`, `isPrimary`
- **Description**: Represents a user employed by a company.
- **Relationships**:
  - **One-to-Many**: `USER` → `CONVERSATION` (A user starts multiple conversations)
  - **One-to-Many**: `USER` → `MESSAGE` (A user sends multiple messages)
  - **One-to-Many**: `USER` → `READ_RECEIPT` (A user receives read receipts)

---

### **3. CONVERSATION**
- **Key Attributes**: `id`, `topic`, `startedBy`, `brokerCompanyId`, `vendorCompanyId`, `startedAt`, `isArchived`
- **Description**: Represents a conversation between a broker and a vendor.
- **Relationships**:
  - **One-to-Many**: `CONVERSATION` → `MESSAGE` (A conversation contains multiple messages)
  - **One-to-Many**: `CONVERSATION` → `READ_RECEIPT` (Tracks read status of messages)

---

### **4. MESSAGE**
- **Key Attributes**: `id`, `conversationId`, `senderId`, `content`, `sentAt`
- **Description**: Represents a message within a conversation.
- **Relationships**:
  - **One-to-Many**: `MESSAGE` → `FILE` (A message can have multiple file uploads)
  - **One-to-Many**: `MESSAGE` → `READ_RECEIPT` (Tracks read status of messages)

---

### **5. FILE**
- **Key Attributes**: `id`, `messageId`, `filePath`
- **Description**: Represents a file uploaded within a message.
- **Relationships**:
  - **One-to-Many**: `MESSAGE` → `FILE` (A message can have multiple file uploads)

---

### **6. READ_RECEIPT**
- **Key Attributes**: `id`, `messageId`, `userId`, `isRead`
- **Description**: Tracks the read status of messages for each user.
- **Relationships**:
  - **One-to-Many**: `MESSAGE` → `READ_RECEIPT` (Each message tracks its read status)
  - **One-to-Many**: `USER` → `READ_RECEIPT` (Each user receives multiple read receipts)


##    Scoping task

We have a system where the companies can log in and manage their profiles. Currently, within the company profile, they can add a single
email address, which is used for all communication that is sent by the system to the company.
We have a requirement to enable the company to add multiple email addresses, so they can be used for different types of communication
(marketing, billing, etc...).
List all the changes that you think must happen to fulfill this requirement. Share any details on how you would approach this requirement.
Feel free to insert any assumptions

###    Departments as Sub-Entities of the Company: 
Each company will have the ability to create departments, which will act as sub-entities within the company profile. These departments will each be tied to a specific email address. The communication for different types (e.g., marketing, billing, support) will be sent to the respective department's email.
  *  During the company registration or setup process, the user will be able to create these departments, assigning a unique email address for each one.
  *  These departments will include typical categories such as Marketing, Finance, Support, and Billing, each responsible for handling different types of communication from the system.

###    Predefined Departments to Streamline User Experience: 
To simplify the process and avoid potential issues with database complexity, cost, and scalability, we would offer a fixed set of predefined department types (e.g., Marketing, Finance, Billing, Support) during the company setup phase. This limits the number of departments a company can create, ensuring that the structure remains manageable while also covering common use cases.

*    When setting up the company profile, the user will be presented with predefined department options, where they will assign email addresses for each communication type. This ensures consistency and avoids the risk of having too many departments that could make the system difficult to manage.
###    Mapping Communication Types to Emails: 
The core requirement of routing communication to specific departments based on the message type will be fulfilled through this department system. For example, each department will handle its relevant communication:

*    Marketing-related communications (e.g., promotions, newsletters) will be routed to the marketing department’s email.
*    Billing-related communications (e.g., invoices, payment reminders) will be sent to the finance department’s email.
*    Support-related communications (e.g., support tickets, customer inquiries) will be directed to the support department’s email.
By organizing communication in this way, each department will be responsible for its area, improving the organization and efficiency of managing emails.

###    Filters for Communication Routing:
Users will also have the option to set up filters to route specific types of communication to specific department emails. This gives users the flexibility to define which types of messages should be sent to which department email. For example:

*    A user could configure the system to route all system errors to the marketing department's email.
*    Or, the user could configure that billing notifications should always go to the finance department’s email.
This level of customization will allow the company to control the flow of communication in a way that best fits their operational structure.

###    Exit Option for Simplified Communication: 
Understanding that some companies may not want to maintain this department-based structure in the future, we will provide an option for users to exit the department system and revert to using only the main company email. This allows the company to simplify its communication setup if needed, providing flexibility without forcing them into a rigid department-based structure.
