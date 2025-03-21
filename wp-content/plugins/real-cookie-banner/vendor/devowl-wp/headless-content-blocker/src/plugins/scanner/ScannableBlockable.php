<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\plugins\scanner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AbstractBlockable;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\HeadlessContentBlocker;
/**
 * Describe a blockable item.
 */
class ScannableBlockable extends AbstractBlockable
{
    private $identifier;
    /**
     * List of original expressions passed through the rules.
     *
     * @var string[]
     */
    private $originalExpressions = [];
    private $extended;
    /**
     * Each expression gets an own instance of `Rule`.
     *
     * @var Rule[]
     */
    private $rules = [];
    /**
     * C'tor.
     *
     * Example array for `$rules`:
     *
     * ```
     * [
     *     [
     *          'expression' => "*google.com/recaptcha*",
     *          'assignedToGroups' => 'script', // can be string[]
     *          'queryArgs' => [
     *               [
     *                   'queryArg' => 'id',
     *                   'isOptional' => true,
     *                   'regExp' => '/^UA-/'
     *               ]
     *          ],
     *          'needsRequiredSiblingRule' => false
     *     ]
     * ]
     * ```
     *
     * @param HeadlessContentBlocker $headlessContentBlocker
     * @param string $identifier
     * @param string $extended The parent extended template identifier
     * @param Rule[]|array[] $rules A list of expressions which hold different scan options; you can also pass
     *                              an array which gets automatically converted to `Rule`.
     * @codeCoverageIgnore
     */
    public function __construct($headlessContentBlocker, $identifier, $extended = null, $rules = [])
    {
        parent::__construct($headlessContentBlocker);
        $this->identifier = $identifier;
        $this->extended = $extended;
        // Create host rule instances
        if (\count($rules) > 0) {
            foreach ($rules as $rule) {
                if (\is_array($rule)) {
                    $ruleInstance = new Rule($rule['expression'], $rule['assignedToGroups'] ?? [], $rule['queryArgs'] ?? [], $rule['needsRequiredSiblingRule'] ?? \false);
                }
                $this->rules[] = $ruleInstance;
            }
        }
        // Create the list of expressions
        foreach ($this->rules as $rule) {
            $this->originalExpressions[] = $rule->getExpression();
        }
        $this->appendFromStringArray($this->originalExpressions);
    }
    // Documented in AbstractBlockable
    public function getBlockerId()
    {
        // This is only used for scanning purposes!
        return $this->getIdentifier();
    }
    // Documented in AbstractBlockable
    public function getRequiredIds()
    {
        return [];
    }
    // Documented in AbstractBlockable
    public function getCriteria()
    {
        return 'scannable';
    }
    /**
     * Check if a set of expressions matches at least one in our configured groups.
     *
     * It returns only `true` when all configured groups got resolved.
     *
     * @param string[][] $expressionsMap
     */
    public function checkExpressionsMatchesGroups($expressionsMap)
    {
        foreach ($this->getGroupsWithExpressionsMap() as $groupName => $groupExpressions) {
            $expressions = $expressionsMap[$groupName] ?? null;
            if ($expressions) {
                // Check if one of our required group expression exists in found expressions
                $exists = !empty(\array_intersect($groupExpressions, $expressions));
                if (!$exists) {
                    return \false;
                }
            } else {
                return \false;
            }
        }
        return \true;
    }
    /**
     * Get a map of `Record<string (group), string[] (expressions)>`.
     */
    public function getGroupsWithExpressionsMap()
    {
        $result = [];
        foreach ($this->rules as $rule) {
            if ($rule->isNeedsRequiredSiblingRule()) {
                continue;
            }
            $assignedToGroups = $rule->getAssignedToGroups();
            foreach ($assignedToGroups as $group) {
                if (!isset($result[$group])) {
                    $result[$group] = [];
                }
                $result[$group][] = $rule->getExpression();
            }
        }
        return $result;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getOriginalExpressions()
    {
        return $this->originalExpressions;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getExtended()
    {
        return $this->extended;
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getRules()
    {
        return $this->rules;
    }
    /**
     * Getter.
     *
     * @param string $expression
     * @return Rule[]
     * @codeCoverageIgnore
     */
    public function getRulesByExpression($expression)
    {
        $result = [];
        foreach ($this->rules as $rule) {
            if ($rule->getExpression() === $expression) {
                $result[] = $rule;
            }
        }
        return $result;
    }
}
