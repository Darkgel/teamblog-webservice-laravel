### Services目录说明（Service层）
1. Service层，所有的服务类放置在该目录下。通常按业务进行分类
2. Service层的职责：
    - 处理牵涉到的外部行为：如发送邮件，使用外部API（如使用队列，调用thrift，调用其他团队的服务等）
    - 包含业务逻辑（主要是工作流逻辑(workflow logic),即完成某个任务的具体流程）：service层是业务逻辑存在的主要地方，辅助Controller层；当需要对数据库进行增删改查时，则应该调用相应的Repository层
3. 所有的服务类都应该继承自AppService类
