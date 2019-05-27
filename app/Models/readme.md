### Models目录说明（Model层）
1. Model层，所有的模型类放置在该目录下。通常按数据库进行分类（eg: DbBlog）
2. Model层的职责（继承自Eloquent class时）：
    - 对应一张数据库表，一个model实例表示表中一条记录
    - 处理property ，如$db, $table，$fillable等；处理scope
    - Accessors & Mutators : 在从model实例中获取或存储属性时对其进行格式化
    - 关联关系配置： 使用hasMany()、belongsTo()等
    - model本身行为的代码(即领域逻辑代码，属于业务逻辑的一部分)，包括了执行model在运行时的状态变化，如status由valid变换成invalid
3. Model层的职责（不继承自Eloquent class时）：
    - 作为一个领域类，包含领域逻辑
4. 当一个完整的领域类被分割成多个数据库表存储在数据库中时，可以在各数据库目录（eg：DbBlog）下创建Domain目录，用于存放完整的领域类。
5. 所有对应数据库表的Model应该间接继承自AppModel。每个数据库目录下（eg: DbBlog）应该包含一个BaseModel（代表该数据库），其他Model继承自该BaseModel
5. 注意：对数据库表进行“增删改查”的操作代码请不要放置到Model，应该将“增删改查”的代码放置到Repository层
