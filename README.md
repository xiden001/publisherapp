
## Publisher Application (Built with Laravel 8)

To install
1. Clone repository
2. copy .env file
3. php artisan migrate
4. php artisan db:seed ( This generates a few topics to test with i.e topic1, topic2, topic3)
5. php artisan serve --port=8000

## ENDPOINTS

Subscribe to Topic
curl -X POST -H "Content-Type: application/json" -d '{ "url": "http://localhost:9000/test1"}' http://localhost:8000/subscribe/topic1
curl -X POST -H "Content-Type: application/json" -d '{ "url": "http://localhost:9000/test2"}' http://localhost:8000/subscribe/topic1

Publish topic to subscribers
curl -X POST -H "Content-Type: application/json" -d '{"message": "hello"}' http://localhost:8000/publish/topic1


Create new topic (if required)

curl -X POST -H "Content-Type: application/json" -d '{"name" : "topic4"}' http://localhost:8000/topics