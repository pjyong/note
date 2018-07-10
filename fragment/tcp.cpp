





//    int pos2 = 0;
//    while((pos2 = rx.indexIn(str, pos2)) != -1){
//        qDebug() << rx.cap(1);
//        pos2 += rx.matchedLength();
//    }


//    qDebug() << sessionID << endl;
//    QTcpSocket* ts = new QTcpSocket();
//    qDebug() << QHostAddress::LocalHost;
//    bool f = ts->bind(QHostAddress("192.168.31.164"));
//    bool f = ts->bind(QHostAddress("172.20.10.3"));
    /*
    if(!f){
        qDebug() << "bind failed";
    }else{
        qDebug() << "bind success";
    }
    */
//    ts->connectToHost("120.76.30.211", 1112);
//    ts->connectToHost("192.168.31.234", 1112);


//    ts->setLocalAddress(QHostAddress("172.20.10.3"));

/*
    ts->waitForConnected(3000);
    if(ts->state() != QTcpSocket::ConnectedState){
        qDebug() << "connect failed";
    }else{
        ts->disconnectFromHost();

    }
    */
//    qDebug() << ts->errorString();
//    QString test = "fsdfksfksfks";
//    ts->write(test.toUtf8());
//    ts->flush();
//    ts->waitForBytesWritten();



//    QNetworkConfigurationManager cManager;
//    qDebug() << cManager.defaultConfiguration().name();


    /*
    foreach (QNetworkConfiguration qc, cManager.allConfigurations()) {
        if(!qc.isValid()){continue;}
//        if(qc.bearerType() == QNetworkConfiguration::BearerWLAN){continue;}
        if(qc.state() != QNetworkConfiguration::Active){continue;}
//        qDebug() << qc.bearerTypeName();
//        qDebug() << qc.type();
//        if(qc.name() == "wlp3s0"){
//            QNetworkSession *qns = new QNetworkSession(qc);
//            qns->open();
//            qns->waitForOpened();
//            if(qns->isOpen()){
//                qDebug() << "connect";
//            }else{
//                qDebug() << "can not connect";
//            }


//        }

            QNetworkAccessManager *manager = new QNetworkAccessManager();
            manager->setConfiguration(qc);

            QEventLoop loop;
            QObject::connect(
                manager,
                SIGNAL(networkAccessibleChanged(QNetworkAccessManager::NetworkAccessibility)),
                        &loop,
                        SLOT(quit()));
            loop.exec();
            if(manager->networkAccessible() != QNetworkAccessManager::Accessible){
                continue;
            }


            qDebug() << qc.type();
            qDebug() << qc.name();
            qDebug() << manager->configuration().name() << "this is current";

            QNetworkReply *reply = getViaHttp("http://m.cheyuu.com/test/fuck3", manager);
            if(replyHasError(reply)){
                return;
            }
            QString str = readAllFromReply(reply);
            qDebug() << str;

    }
    */
   QNetworkAccessManager *manager = new QNetworkAccessManager();
   QNetworkConfiguration qc1 = manager->activeConfiguration();
   qDebug() << qc1.name();
   qDebug() << cManager.allConfigurations();
   QNetworkInterface *interface = new QNetworkInterface();
   foreach (QNetworkInterface qi, interface->allInterfaces()) {
       if(!qc.isValid()){continue;}
       qDebug() << interface->humanReadableName() << interface->hardwareAddress();
   }





    //
   QNetworkReply *reply = getViaHttp("http://m.cheyoo.com/test/fuck2");
   if(replyHasError(reply)){
       return;
   }
   QString str = readAllFromReply(reply);
   QXmlStreamReader xmlReader(str);
   QXmlInputSource *source = new QXmlInputSource();
   source->setData(str);
   bool ok = xmlReader.parse(source);
   if(xmlReader.hasError()){
       qDebug() << "error xml" << endl;
   }
    解析出第一个evaluate
   xmlReader.readNext();
   while(!xmlReader.atEnd())
   {
       if(xmlReader.isStartElement()){
           if(xmlReader.name() == "evaluate"){
               qDebug() << xmlReader.readElementText();
           }
       }
       xmlReader.readNext();
   }
