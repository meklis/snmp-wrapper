# SNMP WRAPPER CLIENT
Блиблотека для работы с https://github.com/meklis/http-snmpwalk-proxy.
Позволяет опрашивать оборудование по SNMP, работает только по версии v2(v2c)

## Как использовать? 
Для работы необходимо, что бы был поднят http-snmpwalk-proxy (инструкция - https://github.com/meklis/Switcher)


Walker позволяет работать только с одним устройством одновременно;
MultiWalker позволяет работать одновременно с большим количеством устройств, указать которые можно через методы setDevice(), setDevices()