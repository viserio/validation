<?php

declare(strict_types=1);

/**
 * This file is part of Narrowspark Framework.
 *
 * (c) Daniel Bannert <d.bannert@anolilab.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Viserio\Component\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Respect\Validation\Validator as RespectValidator;
use Viserio\Component\Validation\Validator;

/**
 * @internal
 *
 * @small
 */
final class ValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $validator = new Validator();
        $validate = $validator->validate(
            [
                'test' => 'foo',
                'foo' => 'foo',
            ],
            [
                'test' => 'alpha|noWhitespace|length:1,32',
                'foo' => RespectValidator::alpha(),
            ]
        );

        self::assertInstanceOf(Validator::class, $validate);
        self::assertTrue($validate->passes());
        self::assertFalse($validate->fails());
        self::assertEquals(
            [
                'test' => true,
                'foo' => true,
            ],
            $validate->valid()
        );
    }

    public function testValidateWithRegex(): void
    {
        $validator = new Validator();
        $validate = $validator->validate(
            [
                'test' => 'foo',
            ],
            [
                'test' => 'regex:/^[A-z]+$/',
            ]
        );

        self::assertInstanceOf(Validator::class, $validate);
        self::assertTrue($validate->passes());
        self::assertFalse($validate->fails());
        self::assertEquals(
            [
                'test' => true,
            ],
            $validate->valid()
        );
    }

    public function testNotValidate(): void
    {
        $validator = new Validator();
        $validate = $validator->validate(
            [
                'test' => 'foo ',
                'foo' => 'aa',
            ],
            [
                'test' => '!alpha|noWhitespace|length:1,32',
                'foo' => RespectValidator::not(RespectValidator::alpha()),
            ]
        );

        self::assertInstanceOf(Validator::class, $validate);
        self::assertFalse($validate->passes());
        self::assertTrue($validate->fails());
        self::assertSame(
            [
                'test' => [
                    'Test must not contain letters (a-z)',
                    'Test must not contain whitespace',
                ],
                'foo' => [
                    'Foo must not contain letters (a-z)',
                ],
            ],
            $validate->invalid()
        );
    }

    public function testNotValidateWith2DatasAndOneRule(): void
    {
        $validator = new Validator();
        $validate = $validator->validate(
            [
                'test' => 'foo ',
                'foo' => ['aa', 'bbb'],
            ],
            [
                'foo' => RespectValidator::not(RespectValidator::alpha()),
            ]
        );

        self::assertInstanceOf(Validator::class, $validate);
        self::assertFalse($validate->passes());
        self::assertTrue($validate->fails());
        self::assertEquals(
            [
                'foo' => [
                    'Foo must not contain letters (a-z)',
                ],
            ],
            $validate->invalid()
        );
    }

    public function testOptionalValidate(): void
    {
        $validator = new Validator();
        $validate = $validator->validate(
            [
                'test' => ' ',
                'foo' => '1',
            ],
            [
                'test' => '?alpha',
                'foo' => '?numeric',
            ]
        );

        self::assertInstanceOf(Validator::class, $validate);
        self::assertTrue($validate->passes());
        self::assertFalse($validate->fails());
    }

    public function testThrowExceptionOnUseNotAndOptionalOnSameRuleValidate(): void
    {
        $this->expectException(\Viserio\Contract\Validation\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('Not (!) and optional (?) cant be used at the same time.');

        $validator = new Validator();
        $validator->validate(
            [
                'test' => ' ',
                'foo' => '1',
            ],
            [
                'test' => '?alpha|!numeric',
            ]
        );
    }
}
