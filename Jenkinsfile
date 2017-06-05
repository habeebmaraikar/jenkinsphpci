pipeline {
    agent any

    stages {

          // stage('Checkout'){
         //     steps{
        //         checkout([
                      //$class: 'GitSCM', 
                      //branches: [[ name: '*/dev' ]], 
                      //doGenerateSubmoduleConfigurations: false,
                      //extensions: [],
                      //submoduleCfg: [],
                      //userRemoteConfigs: [[ url: 'https://Habeeb.Mohamed@git.tusisobar.com/jenkins/jenkins-php-test.git' ]]
                     //])
        //     }       
        // }


        stage('Build and Testing all PHP Tools') {
            steps {
                echo 'Building and Testing all PHP Tools'
                echo pwd()
                sh 'ant build'
            }
        }
        stage('Code Analysing Report') {
            steps {
                echo 'Result and Code Analysing Report..'

                step([$class: 'CheckStylePublisher', pattern: 'build/logs/checkstyle.xml'])
                step([$class: 'PmdPublisher', pattern: 'build/logs/pmd.xml'])
                step([$class: 'DryPublisher', pattern: 'build/logs/pmd-cpd.xml'])
                step([$class: 'AnalysisPublisher', canComputeNew: false, defaultEncoding: '', healthy: '', unHealthy: ''])

                step([
                    $class: 'CloverPublisher',
                    cloverReportDir: 'build/logs/',
                    cloverReportFileName: 'clover.xml',
                    publishHtmlReport: true,
                    healthyTarget: [methodCoverage: 70, conditionalCoverage: 80, statementCoverage: 80], 
                    unhealthyTarget: [methodCoverage: 50, conditionalCoverage: 50, statementCoverage: 50], 
                    failingTarget: [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0]     
                ])

                publishHTML (target: [
                  allowMissing: false,
                  alwaysLinkToLastBuild: false,
                  keepAll: true,
                  reportDir: 'build/api/api/',
                  reportFiles: 'index.html',
                  reportName: "PHPDOX HTML Report"
                ])

                publishHTML (target: [
                  allowMissing: false,
                  alwaysLinkToLastBuild: false,
                  keepAll: true,
                  reportDir: 'build/logs/quality.html/',
                  reportFiles: 'index.html',
                  reportName: "PHP Metrics HTML Report"
                ])


             //script{ 
                //try {
                    // Any ant builder phase that that triggers the unit test phase can be used here.
                    //sh 'ant phpunit'
                //} catch(err) {
                    //step([$class: 'JUnitResultArchiver', testResults: 'build/logs/junit.xml'])
                    //throw err
                //}
             //}


                step([$class: 'JUnitResultArchiver', testResults: 'build/logs/junit.xml'])

                step([
                    $class: 'XUnitBuilder', testTimeMargin: '3000', thresholdMode: 1,
                    thresholds: [
                        [$class: 'FailedThreshold', failureNewThreshold: '', failureThreshold: '0', unstableNewThreshold: '', unstableThreshold: ''],
                        [$class: 'SkippedThreshold', failureNewThreshold: '', failureThreshold: '', unstableNewThreshold: '', unstableThreshold: '']
                    ],
                    tools: [[
                        $class: 'PHPUnitJunitHudsonTestType',
                        deleteOutputFiles: true,
                        failIfNotNew: true,
                        pattern: 'build/logs/junit.xml',
                        skipNoTestFiles: false,
                        stopProcessingIfError: true
                    ]]
                ])
                           
            }
        }

        stage('Deploy') {
            steps {
                echo 'Deploying...'
                
                 dir("${pwd()}") {
                    sh 'ls -la'
                    //sh 'zip -r project.zip src/'
                    //sh 'scp -r project.zip builder@172.104.43.189:/opt/www/Project2'

                    //sh 'scp -r src/* builder@172.104.43.189:/opt/www/Project1'
                    sh 'rsync -r -avz -e ssh src/* builder@172.104.43.189:/opt/www/Project2'
                 }             
            }
        }


    }

    post {
        always {
            echo 'This will always run'
            
        }
        success {
            echo 'This will run only if successful'
            rocketSend channel: 'jenkins-tests', emoji: ':smile:', message: " Successful! - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}| open build ${env.BUILD_NUMBER}>) - <${env.BUILD_URL}console|click here to see the console output>", rawMessage: true
        }
        failure {
            echo 'This will run only if failed'
            rocketSend channel: 'jenkins-tests', emoji: ':sob:', message: " Failed! - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}| open build ${env.BUILD_NUMBER}>) - <${env.BUILD_URL}console|click here to see the console output>", rawMessage: true
        }
        unstable {
            echo 'This will run only if the run was marked as unstable'
            rocketSend channel: 'jenkins-tests', emoji: ':sweat_smile:', message: " Unstable! - ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}| open build ${env.BUILD_NUMBER}>) - <${env.BUILD_URL}console|click here to see the console output>", rawMessage: true
        }
        changed {
            echo 'This will run only if the state of the Pipeline has changed'
            echo 'For example, if the Pipeline was previously failing but is now successful'
        }
    }

}

