namespace java com.jumei.service.microshop
namespace php org.lhy.rpc.demo.child.interf.javaTothrift

service microshopService{
    string getUser(1:list<i64> uid, 2:list<i64> jumei_uid);

    map<string, string> registerWD(1:i64 jumei_uid);

    bool setPhone(1:i64 juemi_uid, 2:string mobile);

    string getRefers(1:list<i64> jumei_uid);

    map<string, string> getOrderPage(1:map<string, string> params, 2:i32 pageSize, 3: i32 pageNum);

    map<string, string> getOrderlistPage(1:map<string, string> params, 2:i32 pageSize, 3: i32 pageNum);
}
