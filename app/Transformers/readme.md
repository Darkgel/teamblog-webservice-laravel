### Transformers目录说明（Transformer层）
1. Transformer层，所有的转换类放置在该目录下。通常按照业务进行分类（eg:Insurance）
2. Transformer层的职责：
    - 处理显示逻辑
    - 管理API接口的输出（使接口的输出与底层的Service，Repository，Model等解耦，这样即使底层数据库表进行了修改，也可以不影响接口的使用）
3. 所有的转换类都应该继承自AppTransformer类