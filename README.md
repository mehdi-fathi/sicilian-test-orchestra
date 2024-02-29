# Sicilian Test Orchestra

Sicilian Test Orchestra is an automated testing package designed for RESTful applications.
It tests all routes with generated faker data to ensure comprehensive coverage and robustness of your application.

a new way testing to close more user's behaviour. We never truncate database after a test.
These days, we have to consider any senario and provide mock data in database for any senario. At the whole, Sometimes
we can't consider all senario.

Even if we considered all senario , Our code is changing every day. we have to update our testing either update mocking
data or factory data. I think, although we consider all user behavior and make all tests, we will see some reportable
and unpredictable bugs. In addition, In
old way, Every test would be run in encapsulated space.

It means others tests never impact on other test's process. While in real world, each of action has some
potential to impact other action.
For this purpose, we need to provide data requirements , in old way.

The main different is this package is not supposed to assert status or response. This package just send request and show
them response and status with other information to you.
When you have 500 error in specifics senario, you are able to detect what's problem. Sometimes you have leaking data in
an end-point in a specifics senario.
So you can check all either response or status so that you make sure everything is ok.

THIS PACKAGE IS UNDER DEVELOPING

## Main goals

### Reaching a realistic tests

users have been sending hundreds of requests would lead to some specific conditions
which might be hide completely. For instance, a user should get a new badge when the one visit 10 different posts with
at least 5 count of like them. ok you arre able to make a test for this purpose like old way. but what if tha user was
limited already?
did you consider that? ok you can make a test for this as well. but what if the user dislike a post? whether keep the
badge?
You see there would be a lot of complicated conditions that would come across 400 error or wrong way.
We honor in Provided a new way to test all facets.

### Being aware of other actions impacts

Since you have been running all tests in isolated method, what if an action
would impact
others badly? For instance, a user make a comment first time and delete that in a soft delete way then user click on
profile menu where
we're showing a number of comments, but we got 500 error. So are we able to consider this in testing? Assuming we
consider
all possible senarios in details. What if we change something in model? We need to update and check all tests again.
It's time-consuming approach.``

### Detailed Reporting

All senarios has been saved in db with request ,response and etc. furthermore you're able
to re-run some specific senarios.

### Keeping data in db

We keep data in database because we believe in those are usefully to debug or check the way of
saving or updating.

## Features

- **Faker Data Integration**: Uses Faker to create realistic and varied test data.
- **Support for HTTP Methods**: Tests routes with different HTTP methods (GET, POST, PUT, DELETE, etc.).
- **Error Handling Tests**: Includes tests for error scenarios and edge cases.
- **Detailed Reporting**: Provides comprehensive reports and logs for easier debugging.
- **Performance Optimized**: Designed to minimize performance impact during testing.

## Requirements

- PHP 7.x or above
- Laravel 8.x

## Contributing

We welcome contributions to the Blind Fold Test package. Please read our [CONTRIBUTING.md](CONTRIBUTING.md) for details
on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

- Faker Library
- [Other dependencies or acknowledgments]
