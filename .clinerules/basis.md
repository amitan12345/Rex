# プロジェクトガイドライン

## 技術スタック
- PHP >= 8.4.0
- Laravel >= 12.0.0
- Nginx >= 1.27.0
- MySQL >= 8.4
- PHPStan >= 2.1
- PHP_CodeSniffer >= 3.12
- Docker

# コンテナ構成
- PHP
  - Laravelアプリケーションを動かすPHPコンテナ
- Nginx
  - 外部ネットワークからLaravelのAPIを実行できるようにするためのコンテナ
- DB
  - MySQLを動かすコンテナ

# ディレクトリ構成
- プロダクトコードは`./app/`に配置する。
- テストコードは`./tests/`に配置する。
- configファイルは`./config/`に配置する。
- DBマイグレーション、シーダーは`./database/`に配置する
- viewファイルは`./resources/`に配置する。
- ルーティングファイルは`./routes`に配置する。

# プロダクトコードのアーキテクチャ
- プロダクトコードはクリーンアーキテクチャに沿って、責務に応じてコードを下記のレイヤー（ディレクトリ）に分離する。
  - Framework
    - ServiceProviders（LaravelのServiceProviderを配置する）
    - Middlewares（LaravelのMiddlewareを配置する）
  - Infrastructure
    - Models（LaravelのEloquentModelを配置する）
      - Factories（EloquentModelを生成するFactoryクラスを配置する）
    - Repositories（DomainレイヤーのAggregationの取得と永続化を行う）
    - QueryServices（特定のユースケースでのみ使用するデータ構造を返す）
  - Presentation
    - Api
      - （API名）
        - （API名）Controller.php
        - （API名）Request.php
        - （API名）Responder.php（JsonResponseを生成するクラス）
  - Application
    - UseCases（アプリケーションのユースケースごとにディレクトリを作成する）
      - （ユースケース名）
        - （ユースケース名）UseCase.php
        - （ユースケース名）UseCaseInput.php
        - （ユースケース名）UseCaseOutput.php
        - （ユースケース名）UseCaseQueryServiceInterface.php（必要な場合のみ実装する）
  - Domain
    - ValueObjects
    - Entities
    - Aggregations
    - RepositoryInterfaces
- 各レイヤーは自分より上位のレイヤーのクラスを参照することはできない。

# プロダクトコードのテストコード実装について
- 基本的に各レイヤー間の依存はモックする。
- テストコードがDBや外部APIなどの外部プロセスに依存する場合は、`tests/Features`に統合テストとして実装し、そうでない場合は`tests/Unit`に単体テストとして実装する。
- ディレクトリ構造はテスト対象のプロダクトコードの`./app/`以下のディレクトリに合わせる。
- モックを使い、分岐網羅になるまでテストケースを作成する。

# コード追加時のルール
- コード追加時には、そのコードのテストコードも実装されていなければならない。
- コード追加時には、PHPStan Level9、PHPCodeSnifferをパスする必要がある。

# プロジェクトのタスクについて
`.clinerules/scram-sprint`にスクラムの1スプリントごとのタスクが記載される。
ファイル名は`sprint\D+\.md`で表現される。

# Clineが必ず守ること
- 作業を完了する際はメモリバンクを必ず更新すること
- コードを実装したらテストコードの必ず実装を行うこと
- コード実装完了後にプロジェクトのテストコードがパスしているか実行して確認し、パスするまで修正を行う
- 今回実装したテストコード以外が失敗しても、そのエラーを必ず修正すること
- コードを実装したら必ずPHPCbfでコード整形を行った後、PHPCodeSnifferで静的解析を行うこと
- コードを実装したら必ずPHPStanで静的解析を行うこと