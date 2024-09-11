pipeline {
    agent any
        environment {
            DOCKER_HUB_CREDENTIALS = credentials('dockerHub')
        }

    stages {
            stage('checkout') {
                steps {
                    git branch: 'local', url: 'https://github.com/javedp3/test.git'
                }
            }
            stage("Clean Cache") {
                steps {
                   sh 'php artisan cache:clear'
                   sh 'php artisan config:clear'
                   sh 'php artisan config:cache'
                }
            }
            stage("Run Tests") {
                steps {
                    sh 'php artisan test'
                }
            stage('install dependensice'){
                steps{
                    sh 'docker build -t myphpapp .'
                    
                }
                
            }
            stage('push to docker hub') {
                steps {
                    // withCredentials([usernamePassword(credentialsId:"dockerHub",passwordVariable:"dockerHubPass",usernameVariable:"dockerHubUser")]){
                       
                    // }
                    sh 'docker tag myphpapp raj01987/myphpapp:latest '
                    sh 'docker login -u ${DOCKER_HUB_CREDENTIALS_USR} -p ${DOCKER_HUB_CREDENTIALS_PSW}'
                    sh 'docker push raj01987/myphpapp:latest '
                }
            }    
            stage('deploy'){
                steps{
                    //echo "deploy successfully..."
                    sh 'docker-compose down && docker-compose up -d'
                    //sh ''
                    //sh 'docker run -d -p 9000:9000 raj01987/myphpapp:latest '
                }
            }    
    }
}



















// pipeline {
//     agent any
//     stages {
//          stage("Install") {
//              steps {
//                  sh 'rm -rf vendor/'
//                  sh 'rm composer.lock'
//                  sh 'composer install'
//             }
//          }
//         stage("Clean Cache") {
//             steps {
//                sh 'php artisan cache:clear'
//                sh 'php artisan config:clear'
//                sh 'php artisan config:cache'
//             }
//         }
//         stage("Run Tests") {
//             steps {
//                 sh 'php artisan test'
//             }
//         }
//     }
//     post {
//         success {
//             sh 'cd "/var/lib/jenkins/workspace/test"'
//             sh 'rm -rf artifact.zip'
//             sh 'zip -r artifact . -x "*node_modules**"'
//             sh 'scp /var/lib/jenkins/workspace/test/artifact.zip /home/ubuntu/artifact'
//             sh 'unzip -o /home/ubuntu/artifact/artifact.zip -d /var/www/html'
//             script {
//                 try {
//                       sh 'chmod 777 /var/www/html/test/storage -R'
//                       sh 'chmod 777 /var/www/html/test/bootstrap/cache -R'
//                 } catch (Exception e) {
//                      echo 'Some file permissions could not be updated.'
//                 }
//             }
//         }
//     }
// }
