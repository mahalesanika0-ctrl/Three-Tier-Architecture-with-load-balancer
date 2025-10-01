# Three-Tier Architecture on AWS
# Introduction
This project leverages AWS to deploy a scalable and secure three-tier web application, with distinct layers for the presentation, application logic, and data storage.
 
## Architecture Overview
![](/img/6260096374053914652.jpg)
## The three-tier architecture divides application responsibilities into clearly defined layers:

* **Web Tier**: Manages HTTP requests, serves static content, and routes dynamic requests to the application layer.

* **Application Tier**: Executes business logic and communicates with the database layer to process data.

* **Database Tier**: Handles data persistence and retrieval, typically using a relational database such as MySQL.

# Infrastructure Components
## Networking setup
At the foundation of the architecture is a custom Amazon VPC, strategically designed with clearly defined public and private subnets to ensure strong network isolation, enhanced security, and granular traffic control.

![](/img/Screenshot%20(14).png)
![](/img/Screenshot%20(13).png)
![](/img/6260084446929735162.jpg)
![](/img/Screenshot%20(18).png)
![](/img/Screenshot%20(19).png)
![](/img/6260084446929735163.jpg)

# Web Tier Components


## The Web Tier is composed of the following components:

* **Auto Scaling Group of EC2 Instances**: Hosts web servers, enabling high availability and automatic scaling based on demand.

* **Internet-Facing Application Load Balancer (ALB)**: Distributes incoming HTTP/HTTPS traffic evenly across instances to improve performance and fault tolerance.

* **Custom Amazon Machine Image (AMI)**: Ensures consistent, repeatable, and version-controlled deployments across all EC2 instances.
![](/img/6260084446929735165%20(1).jpg)

# Application Tier
## The Application Tier includes the following components:

* **Auto Scaling Group of EC2 Instances**: Runs the core application logic on scalable application servers, ensuring high availability and performance under varying load.

* **Internal Application Load Balancer (ALB)**: Distributes traffic received from the Web Tier across the application instances within private subnets.

* **Custom Amazon Machine Image (AMI)**: Guarantees consistent, reliable, and repeatable deployments of the application code across all instances.
![](/img/6260084446929735167.jpg)
![](/img/6260084446929735168.jpg)


# Database Tier
## The Database Tier comprises:

* **Managed Relational Database Service (Amazon RDS)**: Utilizes MySQL for reliable, fully managed database operations.

* **Multi-AZ Deployment**: Ensures high availability with automatic failover across availability zones.

* **Automated Backups and Monitoring**: Provides continuous data protection, point-in-time recovery, and proactive health monitoring.
![](/img/Screenshot%20(16).png)
![](/img/6260084446929735170.jpg)

# Content Delivery and Storage
## To optimize performance and scalability, the architecture includes:

* **Amazon CloudFront**: A global content delivery network (CDN) that accelerates content delivery by caching static assets at edge locations worldwide.

* **Application Load Balancer**: Distributes incoming traffic across multiple web servers, efficiently handling both static and dynamic content to improve responsiveness and fault tolerance.
![](/img/6260084446929735172.jpg)

# Implementation Steps

# 1.Network Infrastructure

* Create a **custom VPC** (e.g., mycustomvpc) with a CIDR block such as 10.0.0.0/16.

* Configure **public and private subnets** across multiple **Availability Zones** for high availability and fault tolerance.

* Set up **route tables** to manage traffic flow between subnets.

* Deploy a **NAT Gateway** in a public subnet to provide secure outbound internet access for resources in private subnets (e.g., application servers or for database updates/patches).

# 2. Database Tier

* Launch an **Amazon RDS MySQL** instance within the private subnets.

* Configure **security groups** to allow database access only from the Application Tier.

* Ensure the **RDS** instance is not publicly accessible—accessible exclusively through the Application Tier.

* Store and manage **secure database** connection details in the application configuration (e.g., using environment variables or AWS Secrets Manager).

# 3. Application Tier

* Create a custom **AMI** that includes the application code and runtime environment.

* Define a **Launch Template** for EC2 instances to ensure consistent configurations.

* Deploy an **internal Application Load Balancer (ALB)** to route traffic from the Web Tier to application servers in private subnets.

* Configure **Auto Scaling** to automatically adjust the number of application instances based on demand and performance metrics.

# 4. Web Tier

* Build a **custom AMI** preconfigured with a web server (e.g., Apache or NGINX).

* Use a **Launch Template** to provision EC2 instances running the web server.

* Deploy an **internet-facing Application Load Balancer (ALB)** to distribute incoming HTTP/HTTPS traffic across web instances.

* Enable **Auto Scaling** to handle fluctuations in user traffic and ensure high availability.

# Security Considerations

* **RDS instances** are deployed in **private subnets** with **no direct public access**.

* The **Application Tier** is accessible  **only via the internal ALB** from the Web Tier.

* The **Web Tier** is exposed to the internet through the **external ALB**, but access is strictly **controlled via security groups.**

* **Security groups** enforce strict traffic flow only between designated tiers (Web → App → DB).

* **NAT Gateway enables secure outbound traffic** from private subnets without exposing internal resources to the public internet.

# Performance Features

* **Auto Scaling** ensures the infrastructure automatically adapts to changes in user traffic.

* **Application Load Balancers** evenly distribute traffic, preventing bottlenecks and improving fault tolerance.

* **Multi-AZ deployments** (especially for RDS) provide **high availability and automated failover** capabilities.

# Usage Flow

* Users send HTTP/HTTPS requests to the **Web Tier ALB.**

* The **Web Tier** serves static content directly and **forwards dynamic requests** to the **Application Tier** via the internal ALB.

* The **Application Tier** processes business logic and communicates with the **Database** Tier to retrieve or store data.

* The **Database Tier** manages **secure, persistent data storage,** isolated from public access.

# Monitoring and Observability

* Utilize **Amazon CloudWatch** for monitoring **EC2 instances,** **load balancers,** and **RDS metrics.**

* Enable **detailed logging, custom dashboards,** and **CloudWatch alarms** to maintain operational visibility and respond to issues proactively.

# Conclusion

* This solution implements a **classic three-tier architecture** on AWS, delivering a **scalable, secure,** and **highly available** environment. It follows **AWS best practices** by:

* Isolating components into dedicated tiers using private networking,

* Using **load balancers** for efficient traffic distribution and failover,

* Implementing **Auto Scaling** for elasticity,

* And applying strict **security controls** through VPC design and security groups.


Unlike architectures that depend on Amazon S3 for static content storage, this solution serves all content directly from EC2 instances, providing complete control over the application stack.
