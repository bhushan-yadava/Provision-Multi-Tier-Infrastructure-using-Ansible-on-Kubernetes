🚀 Provision Multi-Tier LAMP Stack using Ansible on Kubernetes

📘 Project Overview

This project provisions a Multi-Tier LAMP (Linux, Apache, MySQL, PHP) Stack on a Kubernetes cluster using Ansible automation.
All Docker images are built manually from base Ubuntu images (no pre-built images used), ensuring full transparency and control of the build process.

It demonstrates a real-world DevOps workflow integrating:

Ansible for provisioning and automation

Docker for custom image building

Kubernetes for container orchestration and service exposure

This setup reflects production-ready multi-tier infrastructure management — a perfect example of Infrastructure-as-Code (IaC) with Ansible on Kubernetes.

🧩 Architecture
+-----------------------------+
|     Kubernetes Cluster      |
|-----------------------------|
|  +-----------------------+  |
|  |  Apache/PHP Pods      |  |  --> Web Tier (Frontend)
|  |  PHP App + HTML Files |  |
|  +-----------------------+  |
|  +-----------------------+  |
|  |  MySQL Stateful Pod   |  |  --> Database Tier (Backend)
|  |  Persistent Storage   |  |
|  +-----------------------+  |
|-----------------------------|
|  PVCs | Services | Namespace|
+-----------------------------+


Automation Flow:

Ansible builds custom Docker images (Apache, PHP, MySQL)

Ansible applies Kubernetes manifests (Deployments, PVCs, Services)

Ansible initializes the database using a Kubernetes Job



🧱 Project Structure

provision-lamp-ansible-k8s/
├── ansible.cfg
├── inventory
├── group_vars/
│   └── all.yml
├── roles/
│   ├── images/
│   │   ├── tasks/main.yml
│   │   └── templates/
│   │       ├── Dockerfile.apache
│   │       ├── Dockerfile.mysql
│   │       └── Dockerfile.php
│   ├── k8s-deploy/
│   │   ├── tasks/main.yml
│   │   └── templates/
│   │       ├── lamp-deployment.yaml.j2
│   │       ├── lamp-service.yaml.j2
│   │       └── lamp-pvc.yaml.j2
│   └── init-db/
│       ├── tasks/main.yml
│       └── templates/db-init-job.yaml.j2
└── site.yml



⚙️ Technologies Used

Ansible – Infrastructure as Code automation

Docker – Image building and containerization

Kubernetes – Cluster orchestration and service management

YAML & Jinja2 – Declarative configuration and templating

Ubuntu Base Images – Custom Linux setup for each tier




🧰 Prerequisites

Make sure the following tools are installed:

Tool	Version	Purpose
🐍 Python	≥ 3.8	Runs Ansible
⚙️ Ansible	≥ 2.15	Provision automation
🐳 Docker	≥ 24	Build custom images
☸️ Kubernetes (Minikube/KIND)	≥ 1.29	Container orchestration
🔗 kubectl	≥ 1.29	Manage Kubernetes resources


🪜 Setup & Usage
1️⃣ Clone the Repository
git clone https://github.com/bhushan-yadava/provision-lamp-ansible-k8s.git
cd provision-lamp-ansible-k8s

2️⃣ Start Kubernetes
minikube start
kubectl get nodes

3️⃣ Configure Variables

Edit your configuration in:

group_vars/all.yml


You can set registry URL, namespace, MySQL credentials, PVC sizes, etc.

4️⃣ Build Images
ansible-playbook site.yml --tags "images"


This step:

Builds Apache, PHP, and MySQL Docker images

Uses Dockerfiles from roles/images/templates

(Optional) Push to your private/local registry


5️⃣ Deploy on Kubernetes
ansible-playbook site.yml --tags "k8s-deploy"


This step:

Creates Kubernetes Namespace, PVCs, Deployment, and Service

6️⃣ Initialize Database
ansible-playbook site.yml --tags "init-db"


This runs a Kubernetes Job to create:

lampdb database

lampuser with privileges


7️⃣ Verify Deployment
kubectl get pods -n lamp
kubectl get svc -n lamp


8️⃣ Access Web Application
minikube service lamp-stack-service -n lamp


This opens the PHP app in your browser 🎉



🧠 Key Ansible Roles
Role	Description
images	Builds Docker images from Ubuntu base
k8s-deploy	Deploys Kubernetes PVCs, Deployments & Services
init-db	Runs database initialization job
🧩 Example Workflow Diagram
Ansible Playbook
   |
   |---> Build Base Images (Docker)
   |---> Deploy YAML Templates (Kubernetes)
   |---> Initialize Database (Job)

🧾 Logs & Debugging
# View Ansible logs
ansible-playbook site.yml -vvv

# Check pod status
kubectl get pods -n lamp

# Inspect logs of a specific pod
kubectl logs <pod-name> -n lamp

🔒 Security Best Practices

Store credentials (like DB password) in Ansible Vault

Limit NodePort exposure; prefer Ingress for production

Use private Docker registry for image distribution

Apply RBAC policies for the lamp namespace

🧰 Future Enhancements

Add Prometheus + Grafana monitoring

Integrate Jenkins CI/CD pipeline for automated deployment

Deploy via Helm chart for reusability

Use Secrets & ConfigMaps for app configuration
