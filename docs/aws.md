# Amazon Web Services

## Services to activate

- 1 EC2 `t2.micro` instance
- 1 RDS MySQL `db.t2.micro` instance


## SSH to EC2 instance

Go to [EC2 AWS Dashboard](https://eu-west-3.console.aws.amazon.com/ec2/v2/home) to know your ec2 public dns info, then run:

```sh
ssh -i EC2Key.pem ec2-user@${PUBLIC_DNS}
```


## Setup the EC2 instance installing everything we need

```sh
# Update system
sudo yum update

# Install Docker + Git + MySQL
sudo yum install docker git mysql

# Start the Docker service
sudo service docker start

# In order to user docker command without root privileges (sudo), we need to add ec2-user to the docker group
sudo usermod -aG docker ec2-user

# Clone my-hobbies
git clone https://github.com/lipingZLP/my-hobbies.git

# Install npm
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.34.0/install.sh | bash
. ~/.nvm/nvm.sh
nvm install node
```


## Connect the RDS instance from the EC2 Instance

This is necessary, so that the EC2 instance can communicate with the RDS instance.  
Both instances are on the same VPC.
We have to go to ["VPC > Security Groups"](https://eu-west-3.console.aws.amazon.com/vpc/home#SecurityGroups:), select the default security group
Click on "Inbound Rules" > "Edit", and add the following:

```
Type: MYSQL/Aurora
Protocol: TCP
Port range: 3306
Source: 172.31.xxx.xxx/32
Description: IP of the EC2 instance
```

And click on the `Save Rules` button.

To connect to the mysql database, you can run the following:

```sh
mysql -h ${ENDPOINT} -P 3306 -u admin -p
```

(don't forget to create the `myhobbies` database)


## Update the website after a change

```
# ssh to your ec2 instance, then run:
cd my-hobbies
git pull

# if we need to migrate database:
docker exec -it myhobbies-apache php artisan migrate

# To regenerate js and css files:
npm run dev
```
