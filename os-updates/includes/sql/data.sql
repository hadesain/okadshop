#IF COL_LENGTH('{langs}', 'default_lang') IS NULL
#BEGIN
#    ALTER TABLE {langs}
#    ADD [default_lang] INT NOT NULL AFTER `datetime_format`
#END
#
#
#IF COL_LENGTH('om_langs', 'default_lang') IS NULL
#BEGIN
#    ALTER TABLE om_langs
#    ADD [default_lang] INT NOT NULL AFTER `datetime_format`
#END
#
# IF COL_LENGTH('om_langs','default_lang') IS NULL
# BEGIN
#ALTER TABLE om_langs
#    ADD [default_lang] INT NOT NULL AFTER `datetime_format`
# END
#
#
#ALTER TABLE langs ADD `default_lang` INT NOT NULL AFTER `datetime_format`;
#ALTER TABLE currencies ADD `default_currency` INT NOT NULL AFTER `sign`;