# Sicilian Test Orchestra

Sicilian Test Orchestra is an automated testing package designed for RESTful applications.
It tests all routes with generated faker data to ensure comprehensive coverage and robustness of your application.

a new way testing to close more user's behaviour. We never truncate database after a test.
These days, we have to consider any senario and provide mock data in database for any senario.At the whole, Sometimes we
can't consider all senario.

Even if we considered all senario , Our code is changing every day. we have to update our testing either update mocking
data or factory data. I think, although we consider all user behavior and make all tests, we will see some reportable and unpredictable bugs. In addition, In
old way, Every test would be run in encapsulated space.

It means others tests never impact on other test's process. While in real world, each of action has some
potential to impact other action.
For this purpose, we need to provide data requirements , in old way.

THIS PACKAGE IS UNDER DEVELOPING

## Features

- **Automatic Route Testing**: tests all routes in your application with strategy.
- **Faker Data Integration**: Uses Faker to create realistic and varied test data.
- **Support for HTTP Methods**: Tests routes with different HTTP methods (GET, POST, PUT, DELETE, etc.).
- **Error Handling Tests**: Includes tests for error scenarios and edge cases.
- **Detailed Reporting**: Provides comprehensive reports and logs for easier debugging.
- **Performance Optimized**: Designed to minimize performance impact during testing.
- **More close user** : Provided a new way to test all facets.

## Requirements

- PHP 7.x or above
- Laravel 8.x

## Contributing``

We welcome contributions to the Blind Fold Test package. Please read our [CONTRIBUTING.md](CONTRIBUTING.md) for details
on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

- Faker Library
- [Other dependencies or acknowledgments]
